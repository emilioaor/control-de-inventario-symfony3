/*
    Controlador para los detalles en los movimientos
    de inventario
    @author Emilio Ochoa http://emilioochoa.com.ve
 */

var init;

function initDetail(initDetail)
{
    init = initDetail;
}

function removeDetail(id)
{
    $("#row" + id).html('');
}

function addDetail()
{
    var html = '';

    init.lastDetail++;

    html += '<tr id="row' + init.lastDetail + '">';
    html +=    '<td>';
    html +=         '<select name="detail[' + init.lastDetail + '][productId]" class="form-control">';

    for (var product in init.products) {

        html +=             '<option value="' + init.products[product].id + '">';
        html +=                 init.products[product].name;
        html +=             '</option>';
    }

    html +=         '</select>';
    html +=     '</td>';
    html +=     '<td><input type="text" id="textQuantity' + init.lastDetail + '" name="detail[' + init.lastDetail + '][quantity]" class="form-control" value="0" onkeyup="calculateTotal(' + init.lastDetail + ')"></td>';
    html +=     '<td><input type="text" id="textCost' + init.lastDetail + '" name="detail[' + init.lastDetail + '][cost]" class="form-control" value="0" onkeyup="calculateTotal(' + init.lastDetail + ')"></td>';
    html +=     '<td><input type="text" id="textTotal' + init.lastDetail + '" name="detail[' + init.lastDetail + '][total]" class="form-control" value="0" disabled></td>';
    html +=     '<td><button type="button" class="btn btn-danger" onclick="removeDetail(' + init.lastDetail + ')"><span class="' + init.iconRemove + '"></span></button></td>';
    html += '</tr>';

    $("#spaceDetail").append(html);
}

function calculateTotal(key)
{
    var quantity = $("#textQuantity" + key).val();
    var cost = $("#textCost" + key).val();
    var total = cost * quantity;

    $("#textTotal" + key).val(total);
}