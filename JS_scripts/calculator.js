let Calculator = document.forms["Calculator"];
let Calculator_Equal_Button = Calculator["equal"];
let selected_Operation_Message = document.getElementById("operation_Selected");
let showResult = document.getElementById("operation_Result");
let fields = document.getElementsByClassName("calculatorField");
let buttons = document.getElementsByClassName("calculatorButton");
let operations = document.getElementsByClassName("operation");
let operations_number, buttons_number, fields_number;
operations_number = operations.length;
buttons_number = buttons.length;
fields_number = fields.length;
let current_Operation,
  current_Field = undefined;
let current_Selected_Field = document.getElementById("current_Selected_Field");
clicks_per_buttons = [];
let current_fields = ["", ""];
function append_field_logic(fieldNumber = "", button_number = "") {
  iteration = clicks_per_buttons[button_number];
  order = buttons[button_number].value.repeat(iteration);
  value_for_field_insertion = order;
  fields[fieldNumber].value =
    current_fields[current_Field] + value_for_field_insertion;
  current_fields[current_Field] = fields[fieldNumber].value;
}
for (let i = 0; i < 10; i++) {
  clicks_per_buttons[i] = 1;
}
for (let i = 0; i < buttons_number; i++) {
  buttons[i].addEventListener("click", () => {
    if (current_Field === undefined) {
      alert("Please select a field for the value to be written!");
    } else if (current_Field === 0) {
      append_field_logic(current_Field, i);
    } else if (current_Field === 1) {
      append_field_logic(current_Field, i);
    }
  });
}
for (let i = 0; i < fields_number; i++) {
  fields[i].addEventListener("click", () => {
    current_Field = i;
    current_Selected_Field.innerHTML = current_Field + 1;
    current_field = undefined;
  });
  fields[i].addEventListener("keyup", () => {
    if (i === 0) {
      if (String(fields[i].value) === "") {
        current_fields[0] = "";
      }
    } else if (i === 1) {
      if (String(fields[i].value) === "") {
        current_fields[1] = "";
      }
    }
  });
}
for (let i = 0; i < operations_number; i++) {
  operations[i].addEventListener("click", () => {
    if (operations[i].name == "Power") {
      selected_Operation_Message.innerHTML =
        operations[i].value +
        " " +
        operations[i].name +
        ' <br> !!! <b>a</b><sup>n</sup> ,where <br> "a" - value in the first field <br> "b" - value in the second field';
      current_Operation = operations[i].name;
    } else if (operations[i].name == "Root Extraction") {
      selected_Operation_Message.innerHTML =
        operations[i].value +
        " " +
        operations[i].name +
        ' <br> !!! <sup>b</sup> &radic; <sub>a</sub> ,where <br> "a" - value in the first field <br> "b" - order of the root is the value in the second field';
      current_Operation = operations[i].name;
    } else {
      selected_Operation_Message.innerHTML =
        operations[i].value + " " + operations[i].name;
      current_Operation = operations[i].name;
    }
  });
}

Calculator_Equal_Button.addEventListener("click", () => {
  let Calculator_Value1 = Number(Calculator["value1"].value);
  let Calculator_Value2 = Number(Calculator["value2"].value);

  if (current_Operation === "Addition") {
    showResult.innerHTML = Calculator_Value1 + Calculator_Value2;
  } else if (current_Operation === "Subtraction") {
    showResult.innerHTML = Calculator_Value1 - Calculator_Value2;
  } else if (current_Operation === "Multiplication") {
    showResult.innerHTML = Calculator_Value1 * Calculator_Value2;
  } else if (
    Calculator_Value1 === 0 &&
    Calculator_Value2 === 0 &&
    current_Operation === "Division"
  ) {
    alert("0 divided by 0 can't be done!!!");
  } else if (current_Operation === "Division" && Calculator_Value2 === 0) {
    alert(
      "Make sure that the second field doesn't have the value 0 or that it is not empty,because it will be considered 0 and division by 0 can't be done !"
    );
  } else if (current_Operation === "Division") {
    showResult.innerHTML = Calculator_Value1 / Calculator_Value2;
  } else if (
    Calculator_Value1 === 0 &&
    Calculator_Value1 === 0 &&
    current_Operation === "Power"
  ) {
    alert("0 to the power of 0 can't be done!!!");
  } else if (
    Calculator_Value1 === 0 &&
    Calculator_Value1 < 0 &&
    current_Operation === "Power"
  ) {
    alert("0 to a negative power of can't be done!!!");
  } else if (current_Operation === "Power") {
    showResult.innerHTML = Math.pow(Calculator_Value1, Calculator_Value2);
  } else if (
    current_Operation === "Root Extraction" &&
    Calculator_Value2 <= 0
  ) {
    alert("The order of the root can't be negative of zero!!!");
  } else if (
    (current_Operation === "Root Extraction" && Calculator_Value2 < 2) ||
    (current_Operation === "Root Extraction" &&
      Calculator_Value2 !== parseInt(Calculator_Value2, 10))
  ) {
    alert(
      "The order of the root must be greater or equal with 2 and must be a natural number!!!"
    );
  } else if (
    current_Operation === "Root Extraction" &&
    Calculator_Value2 % 2 === 0 &&
    Calculator_Value1 < 0
  ) {
    alert(
      "Can't extract root of an even number order from a negative value!!!"
    );
  } else if (current_Operation === "Root Extraction") {
    showResult.innerHTML = Math.pow(Calculator_Value1, 1 / Calculator_Value2);
  } else {
    alert("No operation selected!!!");
  }
});
