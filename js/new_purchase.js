var rows = 0;

//isSupplier = false;

class MedicineStock {
  constructor(name, batch_id, expiry_date, quantity, mrp, rate) {
    this.name = name;
    this.batch_id = batch_id;
    this.expiry_date = expiry_date;
    this.quantity = quantity;
    this.mrp = mrp;
    this.rate = rate;
  }
}

class NewMedicine {
  constructor(name, packing, generic_name, supplier_name) {
    this.name = name;
    this.packing = packing;
    this.generic_name = generic_name;
    this.supplier_name = supplier_name;
  }
}

function addRow() {
  if(typeof addRow.counter == 'undefined')
    addRow.counter = 1;
  var previous = document.getElementById("purchase_medicine_list_div").innerHTML;
  var node = document.createElement("div");
  var id = document.createAttribute("id");
  id.value = "medicine_row_" + addRow.counter;
  node.setAttributeNode(id);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      node.innerHTML = xhttp.responseText;
      document.getElementById("purchase_medicine_list_div").appendChild(node);
  };
  xhttp.open("GET", "../ui/php/new_purchase.php?action=add_row&row_id=" + id.value + "&row_number=" + addRow.counter, true);
  xhttp.send();
  //alert(addRow.counter);
  addRow.counter++;
  rows++;
}

function removeRow(row_id) {
  if(rows == 1)
    alert("Can't delete only one row is there!");
  else {
    document.getElementById(row_id).remove();
    rows--;
  }
}

function isSupplier(name) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      xhttp.responseText;
  };
  xhttp.open("GET", "../ui/php/new_purchase.php?action=is_supplier&name=" + name, false);
  xhttp.send();
  return xhttp.responseText;
}

function checkInvoice(invoice_number, error) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      xhttp.responseText;
  };
  xhttp.open("GET", "../ui/php/new_purchase.php?action=is_invoice&invoice_number=" + invoice_number, false);
  xhttp.send();
  if(xhttp.responseText == "true") {
    document.getElementById(error).style.display = "block";
    document.getElementById(error).innerHTML = "already added!";
    return true;
  }
  else
    document.getElementById(error).style.display = "none";
  return false;
}

function isNewMedicine(name, packing) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      xhttp.responseText;
  };
  xhttp.open("GET", "../ui/php/new_purchase.php?action=is_new_medicine&name=" + name + "&packing=" + packing, false);
  xhttp.send();
  return xhttp.responseText;
}

function getAmount(row_number) {
  var qty = document.getElementById("quantity_" + row_number).value;
  var rate = document.getElementById("rate_" + row_number).value;
  document.getElementById("amount_" + row_number).value = qty * rate;

  var parent = document.getElementById('purchase_medicine_list_div');
  var row_count = parent.childElementCount;
  var medicine_info = parent.children;
  var total = 0;
  var amount;
  for(var i = 1; i < row_count; i++) {
    amount = Number.parseFloat(medicine_info[i].children[0].children[7].children[0].children[0].value);
    total += amount;
  }
  document.getElementById("grand_total").value = total;
}


