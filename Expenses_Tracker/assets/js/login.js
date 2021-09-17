const loginButton = document.getElementById("loginButton");
const loginForm = document.getElementById("loginForm");

$().ready(() => {
  checkLoginStatus().then((result) => {
    if (result.ok == 200) {
      renderMainPage();
    } else {
      renderLoginPage();
    }
  });
});

async function checkLoginStatus() {
  const response = await fetch("php/API/checkLogin.php");
  if (!response.ok) {
    const message = `An error has occured: ${response.status}`;
    throw new Error(message);
  }

  const results = await response.json();

  return results;
}

function renderMainPage() {
  // For expenses date
  function customDateTimePicker() {
    if ($(".datetimepicker").length > 0) {
      $(".datetimepicker").datetimepicker({
        format: "DD-MM-YYYY",
        icons: {
          up: "fas fa-angle-up",
          down: "fas fa-angle-down",
          next: "fas fa-angle-right",
          previous: "fas fa-angle-left",
        },
      });
    }
  }

  const body = document.getElementById("root");
  body.innerHTML = `<div class="main-wrapper">
      <div class="header">
        <div class="header-left">
          <a href="index.html" class="logo">
            <img src="assets/img/logo.png" alt="Logo" />
          </a>
          <a href="index.html" class="logo logo-small">
            <img
              src="assets/img/logo-small.png"
              alt="Logo"
              width="30"
              height="30"
            />
          </a>
        </div>
      </div>
    
      <div class="page-wrapper">
        <div class="content container-fluid">
          <div class="row">
            <div class="col-12 col-lg-8">
              <button
                data-bs-toggle="modal"
                data-bs-target="#addExpense"
                class="btn w-100 btn-primary"
              >
                <i class="fas fa-plus"></i> Add Expense
              </button>
              <div class="">
                <div class="card card-table">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-center table-hover datatable">
                        <thead class="thead-light">
                          <tr>
                            <th>Category</th>
                            <th>Expense Date</th>
                            <th>Amount</th>
                            <th class="text-end">Action</th>
                          </tr>
                        </thead>
                        <tbody id="expensesContainer"></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="d-flex">
                <div class="card flex-fill">
                  <div class="card-header">
                    <div
                      class="d-flex justify-content-between align-items-center"
                    >
                      <h5 class="card-title">Analytics</h5>
                    </div>
                  </div>
                  <div class="chart-container">
                    <canvas
                      id="pieChart"
                      width="400"
                      height="100"
                      aria-label="Hello ARIA World"
                      role="img"
                    ></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal custom-modal fade" id="manageCategories">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add Category</h4>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-hidden="true"
            ></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Category </label>
              <input
                class="form-control form-white"
                placeholder="Enter category"
                type="text"
                name="name"
                id="addCategoryName"
              />
            </div>
            <div class="submit-section">
              <button
                type="submit"
                class="btn btn-primary save-category submit-btn"
                data-dismiss="modal"
                onclick="addNewCategory()"
              >
                Add Category
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal custom-modal fade" id="addExpense">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add Expense</h4>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-hidden="true"
            ></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Choose a Category</label>
              <select
                class="form-control form-white mb-1"
                data-placeholder="Choose a Category"
                name="category"
                id="addExpenseModalCategoriesDropDown"
              ></select>
              <button
                data-bs-toggle="modal"
                data-bs-target="#manageCategories"
                class="btn btn-sm btn-white text-primary"
                data-bs-dismiss="modal"
              >
                <i class="far fa-edit me-1"></i><span>Manage Categories</span>
              </button>
            </div>
            <div class="form-group">
              <label>Amount</label>
              <input
                class="form-control form-white"
                placeholder="Enter Amount"
                type="number"
                min="0"
                name="amount"
                id="expenseAmount"
              />
            </div>
            <div class="form-group mb-0">
              <label>Date</label>
              <div class="cal-icon">
                <input
                  class="form-control datetimepicker"
                  id="expenseDate"
                  type="text"
                />
              </div>
            </div>
            <div class="submit-section">
              <button
                type="button"
                data-bs-dismiss="modal"
                class="btn btn-primary save-category submit-btn"
                onclick="addNewExpense()"
              >
                Add
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal custom-modal fade" id="editExpense">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Expense</h4>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-hidden="true"
            ></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Choose a Category</label>
              <select
                class="form-control form-white mb-1"
                data-placeholder="Choose a Category"
                name="category"
                id="editExpenseModalCategoriesDropDown"
              ></select>
              <button
                data-bs-toggle="modal"
                data-bs-target="#manageCategories"
                class="btn btn-sm btn-white text-primary"
                data-bs-dismiss="modal"
              >
                <i class="far fa-edit me-1"></i><span>Manage Categories</span>
              </button>
            </div>
            <div class="form-group">
              <label>Amount</label>
              <input
                class="form-control form-white"
                placeholder="Enter Amount"
                type="number"
                min="0"
                name="amount"
                id="editExpenseAmount"
              />
              <input type="hidden" name="id" id="editExpenseId"/>
            </div>
            <div class="form-group mb-0">
              <label>Date</label>
              <div class="cal-icon">
                <input
                  class="form-control datetimepicker"
                  id="editExpenseDate"
                  type="text"
                />
              </div>
            </div>
            <div class="submit-section">
              <button
                type="button"
                data-bs-dismiss="modal"
                class="btn btn-primary save-category submit-btn"
                onclick="editExpense()"
              >
                Edit
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    `;

  const mainScript = document.createElement("script");
  mainScript.src = "assets/js/main.js";

  const chartJsScript = document.createElement("script");
  chartJsScript.src =
    "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js";
  chartJsScript.integrity =
    "sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==";
  chartJsScript.crossOrigin = "anonymous";
  chartJsScript.referrerPolicy = "no-referrer";

  // Get scripts in order, Avoid script dependacies errors - AeOc
  $.getScript("./assets/plugins/moment/moment.min.js", () => {
    $.getScript("./assets/js/bootstrap.min.js", () => {
      $.getScript("./assets/plugins/moment/moment.min.js", () => {
        $.getScript("./assets/js/bootstrap-datetimepicker.min.js", () => {
          body.appendChild(chartJsScript);
          body.appendChild(mainScript);
          customDateTimePicker();
        });
      });
    });
  });
}

function renderLoginPage() {
  loginButton.addEventListener("click", (event) => {
    event.preventDefault();
    const data = {
      email: $("#userEmail").val(),
      password: $("#userPassword").val(),
    };

    loginUser(data)
      .then((result) => {
        if (result.ok == 200) {
          renderMainPage();
        } else {
          console.log(result.message);
        }
      })
      .catch((err) => {});
  });

  async function loginUser(data) {
    const response = await fetch("php/API/login.php", {
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

  const body = document.getElementById("root");
  body.innerHTML = `<div class="main-wrapper login-body">
    <div class="login-wrapper">
      <div class="container">
        <img
          class="img-fluid logo-dark mb-2"
          src="assets/img/logo.png"
          alt="Logo"
        />
        <div class="loginbox">
          <div class="login-right">
            <div class="login-right-wrap">
              <h1>Login</h1>
              <form action="php/login.php" id="loginForm" method="POST">
                <div class="form-group">
                  <label class="form-control-label">Email Address</label>
                  <input
                    type="email"
                    name="email"
                    id="userEmail"
                    class="form-control"
                  />
                </div>
                <div class="form-group">
                  <label class="form-control-label">Password</label>
                  <div class="pass-group">
                    <input
                      type="password"
                      name="password"
                      id="userPassword"
                      class="form-control pass-input"
                    />
                    <span class="fas fa-eye toggle-password"></span>
                  </div>
                </div>
                <button
                  class="btn btn-lg btn-block btn-primary w-100"
                  type="submit"
                  id="loginButton"
                >
                  Login
                </button>
                <div class="login-or">
                  <span class="or-line"></span>
                  <span class="span-or">or</span>
                </div>

                <div class="text-center dont-have">
                  Don't have an account yet?
                  <a href="register.html">Register</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
`;
}
