const categoriesDropDown = document.getElementById(
  "addExpenseModalCategoriesDropDown"
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
      result.categories[expense.category_id].name
    );
  }

  for (let [id, category] of Object.entries(result.categories)) {
    categoriesDropDown.innerHTML += `<option value="${id}">${category.name}</option>`;
  }
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

function appendExpense(id, expense, category) {
  let expenseHtml = `
    <tr id="expense_${id}">
      <td>${category}</td>
        <td>${expense.date}</td>
        <td>$${expense.amount}</td>
                            <td class="text-end">
                              <button
                                class="
                                  btn btn-sm btn-white
                                  text-success
                                  me-2
                                  btn-edit
                                "
                                data-bs-toggle="modal"
                                data-bs-target="#editExpense"
                                id="edit_${id}"
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

  addExpenseToMap(category, expense.amount);

  return expenseHtml;
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
        category
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
