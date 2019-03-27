var items=[];
function addItems(bienes) {
    items = bienes;
    console.log(items);
    var col = ["Nombre", "Descripcion", "Precio", "Descuento", "Iva", "Subtotal"];
    //TABLE HEADER
    var table = document.createElement("table");
    table.setAttribute("id", "table_bienes");
    table.setAttribute("class", "table table-hover");
    table.setAttribute("role","button");
    var tr = table.insertRow(-1);                   // TABLE ROW.
    for (var i = 0; i < col.length; i++) {
        var th = document.createElement("th");      // TABLE HEADER.
        th.innerHTML = col[i];
        tr.appendChild(th);
    }
    //TABLE BODY
    var value = null;
    for (var i = 0; i < bienes.length; i++) {
        var item = bienes[i]
        tr = table.insertRow(-1);
        // tr.onclick= selectItem(item["id"]);
        tr.setAttribute("id", i);
        tr.setAttribute("class", "click");
        tr.setAttribute("onclick","selectItem(event,id)");
        // console.log(item);
        for (var j = 0; j < col.length; j++) {
            var tabCell = tr.insertCell(-1);
            tabCell.setAttribute("id", i);
            tabCell.setAttribute("class", "click");
            value = item[col[j]];
            
            // if ((col[j] == "Descuento") || (col[j] == "Iva")){value = formatPercent(value);}
            if (col[j] == "Descuento"){value = formatPercent(value);}

            if (col[j] == "Precio"){value = formatMoney(value);}
            
            tabCell.innerHTML = value;
        }
    }
    var divContainer = document.getElementById("contenido_bienes");
    divContainer.innerHTML = "";
    divContainer.appendChild(table);
}

function formatMoney(number) {
    return '$ '+ number.toLocaleString('en-US');
}

function formatPercent(number) {
    return number.toLocaleString('en-US') + ' %';
}

var item = null;
var item_ant=null;
// obtengo ID de eventos
function selectItem(e,pos) {
    $('#' + pos).toggleClass('item-seleccion');
    if ($('#' + pos).hasClass('item-seleccion')) {
        item_ant=item;
        if (item_ant){
            $('#' + item_ant).toggleClass('item-seleccion');
        }
        // Guardo id de la fila seleccionada
        item = pos;
        $("#item_precio").val(items[pos]["Precio"]);
        $("#cantidad").val(1);
        $("#descuento").val(items[pos]["Descuento"]);
        seleccionaIva(items[pos]["Iva"]);
        $("#subtotal").val(items[pos]["Precio"]);
        $("#idbien").val(items[pos]["Id"]);
        calculaSubtotal();
    } else {
        // Reseteo el item
        item = null;
        $("#item_precio").val('0.00');
        $("#item_dto").val('0.00');
        $("#cantidad").val("");
        $("#descuento").val('0.00');
        seleccionaIva('0.00');
        $("#subtotal").val('0.00');
        $("#idbien").val('0');
    }
   
}

// TODA UNA TARDE TRATANDO DE HACER ESTA PUTA FUNCION!!!! FALTA VERIFICAR
function seleccionaIva(iva_select){
    // console.log(iva_select);
    tabla_ivas = $("#iva option");
    for (var i = 0; i < tabla_ivas.length; i++) {
        var opt = tabla_ivas[i];
        if(opt.innerHTML.trim() == iva_select.trim()){
            opt.setAttribute("selected", "true");
        } else {
            opt.removeAttribute("selected");
        }
        // console.log("value = " + opt.value + " text = " + opt.innerHTML.trim());
    }
}
