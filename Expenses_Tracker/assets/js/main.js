const categoriesDropDown = document.getElementById(
  "addExpenseModalCategoriesDropDown"
);
const editCategoriesDropDown = document.getElementById(
  "editExpenseModalCategoriesDropDown"
);

const expensesBody = document.getElementById("expensesContainer");
let amountPerCategory = new Map(); // Keep count of expenses added to change Pie chart dynamically - AeOc
let pieChart;

// Fetch and Render User Data

async function fetchUserData() {
  const response = await fetch("php/API/getUserData.php");
  if (!response.ok) {
    const message = `An error has occured: ${response.status}`;
    throw new Error(message);
  }

  const results = await response.json();

  return results;
}

fetchUserData()
  .then((result) => {
    renderResult(result);
  })
  .catch((err) => {
    console.log("error while fetching/rendering your data");
  });

function renderResult(result) {
  for (let [id, expense] of Object.entries(result.expenses)) {
    expensesBody.innerHTML += appendExpense(
      id,
      expense,
      result.categories[expense.category_id].name,
      true
    );
  }

  for (let [id, category] of Object.entries(result.categories)) {
    categoriesDropDown.innerHTML += `<option value="${id}">${category.name}</option>`;
    editCategoriesDropDown.innerHTML += `<option value="${id}">${category.name}</option>`;
  }

  // Keep click listner here - AeOc optimization
  addClickListenerForEditButton();

  createChart();
}

// Functions related to category

function addNewCategory() {
  const data = { name: document.getElementById("addCategoryName").value };

  addCategory(data).then((result) => {
    if (result.ok == 200) {
      categoriesDropDown.innerHTML += `<option value="${result.category_id}">${result.name}</option>`;
      $("#manageCategories").modal("hide");
    }
  });
}

async function addCategory(data) {
  const response = await fetch("php/API/addCategory.php", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });

  if (!response.ok) {
    const message = `An error has occured: ${response.status}`;
    throw new Error(message);
  }

  const results = await response.json();

  return results;
}

// Functions related to expenses

async function addExpense(data) {
  const response = await fetch("php/API/addExpense.php", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });
  if (!response.ok) {
    const message = `An error has occured: ${response.status}`;
    throw new Error(message);
  }

  const results = await response.json();

  return results;
}

async function deleteExpenseFetch(id) {
  const response = await fetch("php/API/deleteExpense.php", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify(id),
  });
  if (!response.ok) {
    const message = `An error has occured: ${response.status}`;
    throw new Error(message);
  }

  const results = await response.json();

  return results;
}

async function editExpensePost(data) {
  const response = await fetch("php/API/editExpense.php", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });
  if (!response.ok) {
    const message = `An error has occured: ${response.status}`;
    throw new Error(message);
  }

  const results = await response.json();

  return results;
}

function addNewExpense() {
  const data = {
    category_id: categoriesDropDown.value,
    amount: document.getElementById("expenseAmount").value,
    date: document.getElementById("expenseDate").value,
  };

  addExpense(data).then((result) => {
    if (result.ok == 200) {
      const category =
        categoriesDropDown.options[categoriesDropDown.selectedIndex].text;
      expensesBody.innerHTML += appendExpense(
        result.expense_id,
        { date: data.date, amount: data.amount },
        category,
        true
      );

      updateChart();
      $("#addExpense").modal("hide");
    }
  });
}

function deleteExpense(id) {
  const data = { product_id: id };
  deleteExpenseFetch(data).then((result) => {
    if (result.ok == 200) {
      const category = $("#expense_" + id)
        .children("td:first-child")
        .text();
      const amount = $("#expense_" + id)
        .children("td:nth-child(3)")
        .text()
        .split("$")[1];
      removeExpenseFromMap(category, amount);
      updateChart();
      $("#expense_" + id).remove();
    }
  });
}

function editExpense() {
  const data = {
    id: document.getElementById("editExpenseId").value,
    category_id: editCategoriesDropDown.value,
    amount: document.getElementById("editExpenseAmount").value,
    date: document.getElementById("editExpenseDate").value,
  };

  const category =
    editCategoriesDropDown.options[categoriesDropDown.selectedIndex].text;

  editExpensePost(data).then((result) => {
    if (result.ok == 200) {
      // Change category total amount after edit
      const oldAmount = $("#expense_" + data.id)
        .children("td:nth-child(3)")
        .text()
        .split("$")[1];
      const oldCategory = $("#expense_" + data.id)
        .children("td:nth-child(1)")
        .text();
      if (category == oldCategory) {
        amountPerCategory.set(
          category,
          parseFloat(
            parseFloat(
              amountPerCategory.get(category) -
                parseFloat(oldAmount) +
                parseFloat(data.amount)
            )
          )
        );
      } else {
        amountPerCategory.set(
          oldCategory,
          parseFloat(
            parseFloat(amountPerCategory.get(oldCategory)) -
              parseFloat(oldAmount)
          )
        );

        amountPerCategory.set(
          category,
          parseFloat(
            parseFloat(amountPerCategory.get(category)) + parseFloat(oldAmount)
          )
        );
      }

      $("#expense_" + data.id).remove();
      expensesBody.innerHTML += appendExpense(
        data.id,
        { date: data.date, amount: data.amount },
        category,
        false
      );
      updateChart();
      $("#editExpense").modal("hide");
    }
  });
}

function appendExpense(id, expense, category, editMap) {
  let expenseHtml = `
    <tr id="expense_${id}">
      <td>${category}</td>
        <td>${expense.date}</td>
        <td>$${expense.amount}</td>
                            <td class="text-end">
                              <button
                              id="edit_${id}"
                              data-id="${id}"
                              data-amount="${expense.amount}"
                              data-date="${expense.date}"
                                class="
                                  btn btn-sm btn-white
                                  text-success
                                  me-2
                                  btn-edit
                                "
                                data-bs-toggle="modal"
                                data-bs-target="#editExpense"
                                
                              >
                                <i class="far fa-edit me-1"></i
                                ><span>Edit</span>
                              </button>
                              <button
                                class="
                                  btn btn-sm btn-white
                                  text-danger
                                  btn-delete
                              "
                                id="${id}"
                                onclick="deleteExpense(this.id)"
                              >
                                <i class="far fa-trash-alt me-1"></i
                                ><span>Delete</span>
                              </button>
                            </td>
                          </tr>
    `;
  if (editMap) {
    addExpenseToMap(category, expense.amount);
  }

  return expenseHtml;
}

function addClickListenerForEditButton() {
  $(".btn-edit").click((event) => {
    const id = event.currentTarget.getAttribute("data-id");
    const amount = event.currentTarget.getAttribute("data-amount");
    const date = event.currentTarget.getAttribute("data-date");

    $("#editExpenseAmount").val(amount);
    $("#editExpenseDate").val(date);
    $("#editExpenseId").val(id);
  });
}

// Functions related to Pie chart
function updateChart() {
  const data = updateData();
  pieChart.data = data;
  pieChart.update();
}

function createChart() {
  const data = updateData();
  const ctx = $("#pieChart").get(0).getContext("2d");
  pieChart = new Chart(ctx, {
    type: "pie",
    data: data,
  });
}

function updateData() {
  let colors = [];
  for (let i = 0; i < amountPerCategory.size; i++) {
    colors.push(randomRGBA());
  }
  const data = {
    labels: Array.from(amountPerCategory.keys()),
    datasets: [
      {
        label: "Expenses",
        data: Array.from(amountPerCategory.values()),
        backgroundColor: colors,
        hoverOffset: 4,
      },
    ],
  };

  return data;
}

function randomRGBA() {
  var o = Math.round,
    r = Math.random,
    s = 255;
  return (
    "rgba(" + o(r() * s) + "," + o(r() * s) + "," + o(r() * s) + "," + 1 + ")"
  );
}

function addExpenseToMap(category, amount) {
  if (!amountPerCategory.has(category)) {
    amountPerCategory.set(category, amount);
  } else {
    amountPerCategory.set(
      category,
      parseFloat(
        parseFloat(amountPerCategory.get(category)) + parseFloat(amount)
      )
    );
  }
}

function removeExpenseFromMap(category, amount) {
  amountPerCategory.set(
    category,
    parseFloat(parseFloat(amountPerCategory.get(category)) - parseFloat(amount))
  );
}
