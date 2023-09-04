(function () {
  "use strict";

  const monthNames = [
    "Janvier",
    "Février",
    "Mars",
    "Avril",
    "Mai",
    "Juin",
    "Juillet",
    "Août",
    "Septembre",
    "Octobre",
    "Novembre",
    "Décembre",
  ];

  const dayNames = [
    "Dimanche",
    "Lundi",
    "Mardi",
    "Mercredi",
    "Jeudi",
    "Vendredi",
    "Samedi",
  ];

  document.addEventListener("DOMContentLoaded", function () {
    let theDate = new Date();

    class DateObject {
      constructor(theDate) {
        this.theDay = theDate.getDate();
        this.dayName = dayNames[theDate.getDay()];
        this.theMonth = monthNames[theDate.getMonth()];
        this.theYear = theDate.getFullYear();
        this.daysInMonth = new Date(
          theDate.getFullYear(),
          theDate.getMonth() + 1,
          0
        ).getDate();
        this.firstDayOfMonth =
          dayNames[
            new Date(theDate.getFullYear(), theDate.getMonth(), 1).getDay()
          ];
      }
    }

    let currentDate = new DateObject(theDate);

    function renderCalendar(targetElem) {
      function createElement(elementType, elemClass, appendTarget) {
        const element = document.createElement(elementType);
        element.className = elemClass;
        appendTarget.appendChild(element);
        return element;
      }

      currentDate = new DateObject(theDate);
      const renderTarget = document.getElementById(targetElem);
      renderTarget.remove();
      const newRenderTarget = document.createElement("div");
      newRenderTarget.id = targetElem;
      document.body.appendChild(newRenderTarget);

      const dayView = createElement("div", "day-view", newRenderTarget);
      const dayNameElem = createElement("div", "day-header", dayView);
      dayNameElem.textContent = currentDate.dayName;

      const dayNumber = createElement("time", "day-number", dayView);
      dayNumber.textContent = currentDate.theDay;

      const monthView = createElement("div", "month-view", newRenderTarget);

      const prevMonthSpan = createElement(
        "span",
        "arrow float-left prev-arrow",
        monthView
      );
      prevMonthSpan.addEventListener("click", () =>
        goToMonth(currentDate, false)
      );
      prevMonthSpan.textContent = "<";

      const nextMonthSpan = createElement(
        "span",
        "arrow float-right next-arrow",
        monthView
      );
      nextMonthSpan.addEventListener("click", () =>
        goToMonth(currentDate, true)
      );
      nextMonthSpan.textContent = ">";

      document.onkeydown = (event) => {
        switch (event.keyCode) {
          case 37: // Left key
            goToMonth(currentDate, false);
            break;
          case 39: // Right key
            goToMonth(currentDate, true);
            break;
        }
      };

      const monthSpan = createElement("span", "month-header", monthView);
      monthSpan.appendChild(prevMonthSpan);
      monthSpan.textContent = `${currentDate.theMonth} ${currentDate.theYear}`;
      monthSpan.appendChild(nextMonthSpan);

      for (let i = 0; i < dayNames.length; i++) {
        const dayOfWeek = createElement("div", "day-of-week", monthView);
        dayOfWeek.textContent = dayNames[i].charAt(0);
      }

      const calendarList = document.createElement("ul");
      for (let i = 0; i < currentDate.daysInMonth; i++) {
        const calendarCell = document.createElement("li");
        const calCellTime = document.createElement("time");
        calendarList.appendChild(calendarCell);
        calendarCell.id = `day_${i + 1}`;
        const dayDataDate = new Date(
          theDate.getFullYear(),
          theDate.getMonth(),
          i + 1
        );
        calCellTime.setAttribute("datetime", dayDataDate.toISOString());
        calCellTime.setAttribute(
          "data-dayofweek",
          dayNames[dayDataDate.getDay()]
        );
        calendarCell.className = "calendar-cell";
        if (i === currentDate.theDay - 1) {
          calendarCell.classList.add("today");
        }
        calCellTime.textContent = i + 1;
        calendarCell.appendChild(calCellTime);
        monthView.appendChild(calendarList);
      }

      const dayOne = document.getElementById("day_1");
      const marginLeft = [
        "",
        "49px",
        "98px",
        "147px",
        "196px",
        "245px",
        "304px",
      ];
      const dayOneMarginLeft =
        marginLeft[dayNames.indexOf(currentDate.firstDayOfMonth)];
      if (dayOneMarginLeft) {
        dayOne.style.marginLeft = dayOneMarginLeft;
      }

      const dayHeader = document.querySelector(".day-header");
      const dayNumNode = document.querySelector(".day-number");
      const updateDay = function () {
        const thisCellTime = this.querySelector("time");
        dayHeader.textContent = thisCellTime.getAttribute("data-dayofweek");
        dayNumNode.textContent = this.textContent;
      };

      const calCells = document.querySelectorAll(".calendar-cell");
      calCells.forEach((cell) => {
        cell.addEventListener("click", updateDay);
      });
    }

    renderCalendar("calendarThis");

    function goToMonth(currentDate, direction) {
      if (direction === false) {
        theDate = new Date(theDate.getFullYear(), theDate.getMonth() - 1, 1);
      } else {
        theDate = new Date(theDate.getFullYear(), theDate.getMonth() + 1, 1);
      }
      return renderCalendar("calendarThis");
    }
  });
})();

document.addEventListener("DOMContentLoaded", function () {
  // Récupération des éléments nécessaires
  const loginButton = document.getElementById("login-button");
  const loginModal = document.getElementById("login-modal");
  const closeLogin = document.getElementById("close-login");

  // Afficher la modale lorsque le bouton est cliqué
  loginButton.addEventListener("click", function () {
    loginModal.style.display = "block";
  });

  closeLogin.addEventListener("click", function () {
    loginModal.style.display = "none";
  });
});
