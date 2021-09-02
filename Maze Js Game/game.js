window.onload = function () {
  // Functions

  function startGame() {
    isActive = true;
    changeBackgroundColor("#eeeeee");
  }

  function endGame() {
    if (isActive) {
      isActive = false;
      score += 5;
      haveWon = true;
      displayInfo(haveWon);
    }
  }

  function checkBoundaries() {
    if (isActive) {
      changeBackgroundColor("red");
      haveWon = false;
      isActive = false;
      score -= 10;
      displayInfo(haveWon);
    }
  }

  function changeBackgroundColor(color) {
    for (var i = 0; i < boundariesElements.length; i++) {
      boundariesElements[i].style.backgroundColor = color;
    }
  }

  function displayInfo(haveWon) {
    if (haveWon) {
      statusElement.innerHTML = "You Won!! Your score is " + score + " :)";
    } else {
      statusElement.innerHTML = "You Lost!! Your score is " + score + " :(";
    }
  }

  // DOM

  var boundariesElements = document.getElementsByClassName("boundary");
  var startElement = document.getElementById("start");
  var endElement = document.getElementById("end");
  var statusElement = document.getElementById("status");
  var gameElement = document.getElementById("game");

  console.log(gameElement);

  // Game Variables

  var isActive = false;
  var haveWon = true;
  var score = 0;

  // Event Listeners

  startElement.addEventListener("click", function () {
    startGame();
  });
  endElement.addEventListener("click", function () {
    endGame();
  });
  for (var i = 0; i < boundariesElements.length; i++) {
    boundariesElements[i].addEventListener("mouseover", function () {
      checkBoundaries();
    });
  }
  gameElement.addEventListener("mouseleave", function () {
    checkBoundaries();
  });
};
