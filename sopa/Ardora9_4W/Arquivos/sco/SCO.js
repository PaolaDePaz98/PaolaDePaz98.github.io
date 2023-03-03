<!--
// Hook for Internet Explorer
if (navigator.appName && navigator.appName.indexOf("Microsoft") != -1 &&
	  navigator.userAgent.indexOf("Windows") != -1 && navigator.userAgent.indexOf("Windows 3.1") == -1) {
	document.write('<SCRIPT LANGUAGE=VBScript\> \n');
	document.write('on error resume next \n');
	document.write('Sub fsscorm_FSCommand(ByVal command, ByVal args)\n');
	document.write('  call fsscorm_DoFSCommand(command, args)\n');
	document.write('end sub\n');
	document.write('</SCRIPT\> \n');
}
//-->
doLMSInitialize();
function fsscorm_DoFSCommand(command, args){
//if(command=="mensaje"){
//	alert(args);
//mysco.argumento=command+','+args;
//	mysco.validar_cantidad();
//}
mysco.argumento=args;
if(command=="LMSGetValue"){
	this.valida=mysco.validar_cantidad();
	mysco.tparg="get";
	if(valida)this.valida=mysco.validar_parametro();
	//coloca variable en flash
	if(valida)fsscorm.setVariable(mysco.valor,LMSGetValue(mysco.parametro));
}
else if(command=="LMSSetValue"){
	this.valida=mysco.validar_cantidad();
	mysco.tparg="set";
	if(valida)this.valida=mysco.validar_parametro();
	if(valida)this.valida=mysco.validar_tipoDato();
	mysco.tipoDato=0;
	//coloca variable en flash
	if(valida)LMSSetValue(mysco.parametro, mysco.valor);
}
else if (command=="LMSCommit"){
	doLMSCommit();
	}
else if (command=="LMSGetLastError"){
	fsscorm.setVariable(mysco.argumento,doLMSGetLastError())
	}

else {
	this.err="El primer parametro de la sentencia debe corresponder a LMSGetValue, LMSSetValue ó LMSCommit únicamente";	
	mysco.mensaje(this.err);
	}
}
		
function sco(){
	this.err = "";
	this.argumento="";
	this.parametro="";
	this.valor="";
	this.valida=true;
	this.tipoDato;
	this.tparg="";
	this.ioi="";
		
	this.arrParametros= new Array("cmi.core._children","cmi.core.student_id","cmi.core.student_name","cmi.core.lesson_location","cmi.core.credit",
          "cmi.core.lesson_status","cmi.core.entry","cmi.core.score._children","cmi.core.score.raw","cmi.core.score.max",
          "cmi.core.score.min","cmi.core.total_time","cmi.core.lesson_mode","cmi.core.exit","cmi.suspend_data",
          "cmi.comments","cmi.comments_from_lms","cmi.objectives._children","cmi.objectives._count","cmi.student_data._children",
          "cmi.student_data.mastery_score","cmi.student_data.max_time_allowed","cmi.student_data.time_limit_action","cmi.student_preference._children","cmi.student_preference.audio",
          "cmi.student_preference.language","cmi.student_preference.speed","cmi.student_preference.text","cmi.interactions._children","cmi.interactions._count");
	 this.arrData= new Array("","","","CMIString255","",
		   "CMIVocabulary_Status","","","CMIDecBlank","CMIDecBlank",
		   "CMIDecBlank","","","CMIVocabulary_Exit","CMIString4096",
		   "CMIString4096","","","","",
		   "","","","","CMISIntegerAU",
		   "CMIString255","CMISIntegerSP","CMISIntegerTX","","");
	 this.arrFinalWords= new Array("id","score._children","score.raw","score.max","score.min","status",
			  "id","objectives._count","time","type","correct_responses._count","weighting","student_response",
			  "result","latency","correct_responses.n.pattern","objectives.n.id");
	 this.arrDataFinalWords= new Array("CMIIdentifier","","CMIDecBlank","CMIDecBlank","CMIDecBlank","CMIVocabulary_Status",
			   "CMIIdentifier","CMIIdentifier","CMITime","CMIVocabulary_Interaction","","CMIDecimal","CMIFeedback",
			   "CMIVocabulary_Result","CMITime","CMIFeedback","CMIIdentifier");
//metodos
	 this.mensaje=mensaje;
	 this.validar_CMIString255 = validar_CMIString255;
	 this.validar_CMIVocabulary_Status = validar_CMIVocabulary_Status;
	 this.validar_CMIDecBlank = validar_CMIDecBlank;
	 this.validar_CMIVocabulary_Exit = validar_CMIVocabulary_Exit;
	 this.validar_CMIString4096 = validar_CMIString4096;
	 this.validar_CMISIntegerAU = validar_CMISIntegerAU;
 	 this.validar_CMISIntegerSP = validar_CMISIntegerSP;
	 this.validar_CMISIntegerTX = validar_CMISIntegerTX;	 
	 this.validar_CMIIdentifier = validar_CMIIdentifier;
	 this.validar_CMIVocabulary_Interaction = validar_CMIVocabulary_Interaction;
	 this.validar_CMIFeedback = validar_CMIFeedback;
	 this.validar_CMITime = validar_CMITime;
	 this.validar_CMIDecimal = validar_CMIDecimal;
	 this.validar_CMIVocabulary_Result = validar_CMIVocabulary_Result;
	 this.validar_cantidad=validar_cantidad;
	 this.validar_parametro=validar_parametro;
	 this.validar_FinalWords=validar_FinalWords;
	 this.validar_tipoDato=validar_tipoDato;
	 this.validar_maximo=validar_maximo;
}
function validar_cantidad(){
	var arrNewValues;
	arrNewValues = this.argumento.split(",");
	var count= arrNewValues.length;
	if(count!=2){
		this.err="La cantidad de argumentos enviados no corresponde...";
		mensaje(this.err);
		return false;
	}
	this.parametro=arrNewValues[0];
	this.valor=arrNewValues[1];
	return true
}

function mensaje(err){
  alert(err);
 }

 function validar_CMIString255(){
 	if(this.valor.length>255){
		this.err="La longitud del valor excede los 255 caracteres";
		this.mensaje(this.err);
		return false;
	}
	if(this.valor.indexOf(" ")!=-1){
		this.err="La cadena de caracteres del valor no puede tener espacios en blanco";
		this.mensaje(this.err);
		return false;

	}
 	return true;
 }
 function validar_CMIVocabulary_Status(){
	arrNewValues = new Array("passed","completed","failed","incomplete","browsed","not attempted");
	for(var i=0;i<arrNewValues.length;i++){
		if(arrNewValues[i]==this.valor){
			return true;
		}
	}
	this.err="La palabra no corresponde al Vocabulario Status";
	this.mensaje(this.err);
	return false;
}

 function validar_CMIDecBlank(){
 	var pass=false;
	if(this.valor=="")return true;
 	pass=this.validar_CMIDecimal();
	if(pass)return true;
	else return false;
 }
 function validar_CMIVocabulary_Exit(){
	arrNewValues = new Array("time-out","suspend","logout","");
	for(var i=0;i<arrNewValues.length;i++){
		if(arrNewValues[i]==this.valor){
			return true;
		}
	}
	this.err="La palabra no corresponde al Vocabulario Exit";
	this.mensaje(this.err);
	return false;
}
 function validar_CMIString4096(){
	 if(this.valor.length>4096){
		this.err="La longitud del valor excede los 4096 caracteres";
		this.mensaje(this.err);
		return false;
	}
	return true;
 }
 
 function validar_CMISIntegerAU(){
 	 if(this.valor>=-1 && this.valor<=100)return true;
	 this.err="Los valores para este argumento deben estar entre -1 y 100";
	this.mensaje(this.err);
	return false;
 }
  function validar_CMISIntegerSP(){
	 if(this.valor>=-100 && this.valor<=100)return true;
	 this.err="Los valores para este argumento deben estar entre -100 y 100";
	 this.mensaje(this.err);
	 return false;
 }
 function validar_CMISIntegerTX(){
	 if(this.valor>=-1 && this.valor<=1)return true;
	this.err="Los valores para este argumento deben se -1,0 ó 1";
	this.mensaje(this.err);
	return false;
 }

 function validar_CMIIdentifier(){
 	if(this.valor.length>255){
		this.err="La longitud del valor excede los 255 caracteres";
		this.mensaje(this.err);
		return false;
	}
	if(this.valor.indexOf(" ")!=-1){
		this.err="La cadena de caracteres del valor no puede tener espacios en blanco";
		this.mensaje(this.err);
		return false;

	}
 	return true;
 }
 function validar_CMIVocabulary_Interaction(){
	arrNewValues = new Array("true-false","choice","fill-in","matching","performance","likert","sequencing","numeric");
	for(var i=0;i<arrNewValues.length;i++){
		if(arrNewValues[i]==this.valor){
			return true;
		}
	}
	
	this.err="La palabra no corresponde al Vocabulario Interaction";
	this.mensaje(this.err);
	return false;
 }
 function validar_CMIFeedback(){
	 return true;
 }
 function validar_CMITime(){
 	if(this.valor.length>=10)return true;
	if(this.valor.charAt(4)==":" && this.valor.charAt(7)==":") return true;
	this.err="El formato no es el establecido. HHHH:MM:SS.SS";
	this.mensaje(this.err);
	return false; 
 }
 function validar_CMIDecimal(){
	this.err="Formato invalido";
	 if(this.valor.charAt(0)=="-"){
		for(var i=1;i<this.valor.length;i++){
			if(isNaN(this.valor.charAt(i))){
				if (this.valor.charAt(i)!="."){
					this.mensaje(this.err);
					return false;
				}
			}
		}
		return true;
	 }
	 else if(!isNaN(this.valor.charAt(0))) {
	 	for(var i=1;i<this.valor.length;i++){
			if(isNaN(this.valor.charAt(i))){
				if (this.valor.charAt(i)!="."){
					this.mensaje(this.err);
					return false;
				}
			}
		}
		return true;
	
	 }
 }
 function validar_CMIVocabulary_Result(){
	arrNewValues = new Array("correct","wrong","unanticipated","neutral");
	for(var i=0;i<arrNewValues.length;i++){
		if(arrNewValues[i]==this.valor){
			return true;
		}
	}
	var pass=this.validar_CMIDecimal();
	if(pass)return true;
	this.err="La palabra no corresponde al Vocabulario Result";
	this.mensaje(this.err);
	return false;

}
function validar_parametro(){
	var ing=true;
	for(var i=0;i<this.arrParametros.length;i++){
		if(this.arrParametros[i]==this.parametro){
			this.tipoDato=i;
			return true;
		}
	}
	ing=this.validar_FinalWords();	
	if(ing)return true;
	else {
		this.err="El argumento digitado no corresponde a los argumentos permitidos";
		this.mensaje(this.err);
		return false;
	}
}
function validar_FinalWords(){
	this.ioi="";
	var tmp="";
	var valida= false;
	arrNewValues = this.parametro.split(".");
	if(arrNewValues[0]!="cmi")return false;
	if(arrNewValues[1]=="objectives" ){
		if(isNaN(arrNewValues[2]))return false;
		for(var i=3;i<arrNewValues.length;i++){
			tmp=tmp+arrNewValues[i]+".";
		}
		tmp=tmp.substring(0,tmp.length-1) ;
		for(var i=0;i<6;i++){
			if(tmp==this.arrFinalWords[i]){
				this.tipoDato=30+i;
				valida=this.validar_maximo(arrNewValues[2],"objectives");
				if(valida) return true;
				this.err="La cantidad de objetivos ingresada no corresponde a los objetivos existentes, recuerde que el indice comienza en cero (0).";
				this.mensaje(this.err);
				return false;
			}
		}
		return false;
	}
	
	else if(arrNewValues[1]=="interactions" ){
		if(isNaN(arrNewValues[2]))return false;
		valida=this.validar_maximo(arrNewValues[2],"interactions");
		if(!valida){ 
			this.err="La cantidad de interacciones ingresada no corresponde a las interacciones existentes, recuerde que el indice comienza en cero (0).";
			this.mensaje(this.err);
			return false;
		}
		if(arrNewValues.length==6){
			if(isNaN(arrNewValues[4]))return false;
			if(arrNewValues[3]=="objectives" ){
				if(arrNewValues[5]=="id"){
					this.tipoDato=46;
					if(this.tparg=="get")return false;
					this.ioi=arrNewValues[0]+"."+arrNewValues[1]+"."+arrNewValues[2]+"."+arrNewValues[3];
					valida=this.validar_maximo(arrNewValues[4],"interactions");
					if(valida) return true;
					else{
						this.err="La cantidad de interacciones ingresada no corresponde a las interacciones existentes, recuerde que el indice comienza en cero (0).";
						this.mensaje(this.err);
						return false;
					}
				}
				else return false;
			 }
			else if(arrNewValues[3]=="correct_responses" ){
				if(arrNewValues[5]=="pattern"){
					this.tipoDato=45;
					if(this.tparg=="get")return false;
					this.ioi=arrNewValues[0]+"."+arrNewValues[1]+"."+arrNewValues[2]+"."+arrNewValues[3];
					valida=this.validar_maximo(arrNewValues[4],"interactions");
					if(valida) return true;
					else{
						this.err="La cantidad de interacciones ingresada no corresponde a las interacciones existentes, recuerde que el indice comienza en cero (0).";
						this.mensaje(this.err);
						return false;
					}
				}
				else return false;
			 }
			 else return false;
		}
		
		for(var i=3;i<arrNewValues.length;i++){
			tmp=tmp+arrNewValues[i]+".";
		}
		tmp=tmp.substring(0,tmp.length-1) ;
		for(var i=6;i<15;i++){
			if(tmp==this.arrFinalWords[i]){
				this.tipoDato=30+i;
				return true;
			}
		}
		return false;
	}
	else return false;
}
function validar_tipoDato(){
		var source="";
		var type;
		var pass=false;
		if(this.tipoDato>29){
			this.tipoDato=this.tipoDato-30;
			source="fw";
		}
		if(source!="")	type=this.arrDataFinalWords[this.tipoDato];
		else type=this.arrData[this.tipoDato];
		if(type==""){
			this.err="El argumento especificado es de solo lectura, no aplica para LMSSetValue";
			this.mensaje(this.err);
			return false;
		}
		switch (type) {
			case "CMIString255" :
				pass=this.validar_CMIString255();
			break;
			case "CMIVocabulary_Status" :
				pass=this.validar_CMIVocabulary_Status();
			break;
			case "CMIDecBlank" :
				pass=this.validar_CMIDecBlank();
			break;
			case "CMIVocabulary_Exit" :
				pass=this.validar_CMIVocabulary_Exit();
			break;
			case "CMIString4096" :
				pass=this.validar_CMIString4096();
			break;
			case "CMISIntegerAU" :
				pass=this.validar_CMISIntegerAU();
			break;
			case "CMISIntegerSP" :
				pass=this.validar_CMISIntegerSP();
			break;
			case "CMISIntegerTX" :
				pass=this.validar_CMISIntegerTX();
			break;
			case "CMIIdentifier" :
				pass=this.validar_CMIIdentifier();
			break;
			case "CMITime" :
				pass=this.validar_CMITime();
			break;
			case "CMIVocabulary_Interaction" :
				pass=this.validar_CMIVocabulary_Interaction();
			break;
			case "CMIFeedback" :
				pass=this.validar_CMIFeedback();
			break;
			case "CMIVocabulary_Result" :
				pass=this.validar_CMIVocabulary_Result();
			break;
			case "CMIDecimal" :
				pass=this.validar_CMIDecimal();
			break;
		}
		if(pass)return true;
		else return false;
		
}
 function validar_maximo(ent,tipo){
	var i;
	if(tipo=="objectives"){
		if(this.tparg=="get"){
			i=LMSGetValue('cmi.objectives._count');
			if(ent<=i-1)return true;
			else return false;
		}
		if(this.tparg=="set"){
			i=LMSGetValue('cmi.objectives._count');
			if(ent<=i)return true;
			else return false;
		}
	}
	if(tipo=="interactions"){
		if(this.tparg=="get"){
			i=LMSGetValue('cmi.interactions._count');
			if(ent<=i-1)return true;
			else return false;
						
		}
		if(this.tparg=="set"){
			if(this.ioi!=""){
				i=LMSGetValue(this.ioi+'._count');
				this.ioi="";
				if(ent<=i)return true;
				else return false;
			}
			else{
				i=LMSGetValue('cmi.interactions._count');
				if(ent<=i)return true;
				else return false;
			}
		}
	}
	
 }
 var mysco = new sco();
function fscommand(command, args){
fsscorm_DoFSCommand(command, args);
}

