//GET URL variables and return them as an array.
function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }

    if (vars.length >= 4) {
        var valor = StringFormatVerify(vars.VALOR);
        
        if ((isNaN(vars.ENTIDADE)) || (String(vars.ENTIDADE).length != 5))
        {
            alert('Entidade inválida!');
            return;
        }
        if ((isNaN(vars.SUBENTIDADE)) || (String(vars.SUBENTIDADE).length > 3) || (String(vars.SUBENTIDADE) == "")) {
            alert('SubEntidade inválida!');
            return;
        }
        if ((isNaN(vars.ID)) || (String(vars.ID).length > 4) || (String(vars.ID) == "")) {
            alert('ID inválido!');
            return;
        }
        if (isNaN(valor)) {
            alert('Valor inválido!');
            return;
        }
        else if (valor <= 0) {
            alert('Valor inválido!');
            return;
        }
        
        valor = formatAsMoney(valor);
        GetPaymentRef(vars.ENTIDADE, vars.SUBENTIDADE, vars.ID, valor);
    }
}

function GetPaymentRef(_ENTIDADE, _SUBENTIDADE, _ID, _VALOR) {

    var ENT_CALC = (51 * parseInt(String(_ENTIDADE).charAt(0)) +
    73 * parseInt(String(_ENTIDADE).charAt(1)) +
    17 * parseInt(String(_ENTIDADE).charAt(2)) +
    89 * parseInt(String(_ENTIDADE).charAt(3)) +
    38 * parseInt(String(_ENTIDADE).charAt(4)));
    
    var iCHECKDIGITS = 0;
    var sTMP = "";

    sTMP = String(Right("000" + _SUBENTIDADE.toString(), 3) + Right("0000" + _ID.toString(), 4) + Right("00000000" + (parseFloat(_VALOR) * 100).toFixed(0), 8));
    	
	//Calculate check digits
    iCHECKDIGITS =
        98 - (parseInt(ENT_CALC) +
        3 * parseInt(sTMP.charAt(14)) +
        30 * parseInt(sTMP.charAt(13)) +
        9 * parseInt(sTMP.charAt(12)) +
        90 * parseInt(sTMP.charAt(11)) +
        27 * parseInt(sTMP.charAt(10)) +
        76 * parseInt(sTMP.charAt(9)) +
        81 * parseInt(sTMP.charAt(8)) +
        34 * parseInt(sTMP.charAt(7)) +
        49 * parseInt(sTMP.charAt(6)) +
        5 * parseInt(sTMP.charAt(5)) +
        50 * parseInt(sTMP.charAt(4)) +
        15 * parseInt(sTMP.charAt(3)) +
        53 * parseInt(sTMP.charAt(2)) +
        45 * parseInt(sTMP.charAt(1)) +
        62 * parseInt(sTMP.charAt(0))) % 97;

    var _PaymentRef = Right("000" + _SUBENTIDADE, 3) + " " + Mid(Right("0000" + _ID, 4), 0, 3) + " " + Mid(Right("0000" + _ID, 4), 3, 1) + Right("00" + iCHECKDIGITS.toString(), 2);

	var newdiv = document.createElement('div');
	newdiv.innerHTML = _ENTIDADE;
    //return results
    document.getElementById("Entidade").appendChild(newdiv);
	
	var newdiv2 = document.createElement('div');
	newdiv2.innerHTML = _PaymentRef;
	
    document.getElementById("Ref").appendChild(newdiv2);
	
	var newdiv3 = document.createElement('div');
	newdiv3.innerHTML = _VALOR;
	
    document.getElementById("Valor").appendChild(newdiv3);

}

//Mid Function
function Mid(value, index, n)
{
    var result = String(value).substring(index, index + n);
    return result;
}
//Right function
function Right(value, n) {
    var result = String(value).substring(String(value).length, String(value).length - n);
    return result;
}

function formatAsMoney(mnt) {
    mnt -= 0;
    mnt = (Math.round(mnt * 100)) / 100;
    return (mnt == Math.floor(mnt)) ? mnt + '.00' : ((mnt * 10 == Math.floor(mnt * 10)) ? mnt + '0' : mnt);
}

function StringFormatVerify(value)
{
    var count = 0;
    var result = "";
    for (var i = 0; i <= String(value).length; i++)
    {
        if ((String(value).charAt(i) == ".") || (String(value).charAt(i) == ",")) count++;
    }
    if (count > 1) {

        for (var i = 0; i <= String(value).length; i++) {
            if (count > 1) {
                if ((String(value).charAt(i) == ".") || (String(value).charAt(i) == ",")) {
                    count--;
                }
                else { 
                    result +=String(value).charAt(i);
                }
            }
            else
            { 
                result +=String(value).charAt(i);
            }
        }

    }
    else {
        result = value;
    }
    return String(result).replace(",",".");
}
  