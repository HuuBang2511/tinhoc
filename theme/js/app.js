// import * as bootstrap from 'bootstrap'

function ready() {
  console.log("app");
  const links = document.querySelectorAll(".nav-main-link");
  links.forEach((link) => {
    if (link.href == location.origin + location.pathname) {
      link.classList.add("active");
      setTimeout(() => link.scrollIntoView(), 50);
    } else {
      link.classList.remove("active");
    }
  });

  // //code slider
  // $( "#slider-range" ).slider({
  //   range: true,
  //   min: 0,
  //   max: 1000,
  //   values: [ 50, 200 ],
  //   slide: function( event, ui ) {
  //     $( "#nocgiasearch-dientich_dat" ).val( ui.values[ 0 ] + "-" + ui.values[ 1 ]);
  //   }
  // });
  // //end code slider
}

// Side content Script
function customDashboard() {
  const toggleDiv = (input, div) => {
    if (input == null || div == null) return;

    if (input.checked) {
      div.classList.remove("d-none");
    } else {
      div.classList.add("d-none");
    }
  };

  const setToLocalStorage = (input) => {
    if (input == null) return;

    localStorage.setItem(input.name, input.checked);
  };

  const getFromLocalStorage = (input) => {
    if (input == null) return;
    let value = localStorage.getItem(input.name);
    input.checked = value != "false";
  };

  const inputs = document.querySelectorAll(".custom-dashboard input");
  inputs.forEach((input) => {
    const div = document.getElementById(input.name);
    if (div == null) {
      console.log(`Input ${input.name} not found`);
      return;
    }

    getFromLocalStorage(input);
    toggleDiv(input, div);

    input.onchange = () => {
      toggleDiv(input, div);
      setToLocalStorage(input);
    };
  });
}

if (document.readyState === "complete" || document.readyState !== "loading") {
  ready();
  customDashboard();
} else {
  document.addEventListener("DOMContentLoaded", ready);
}
