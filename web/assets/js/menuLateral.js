  function submenu() {
      var x = document.getElementById("submenuUsuario");
      var y = document.getElementsByClassName("arrow")[0];
      if (x.style.display != "block") {
          x.style.display="block";
          y.style.display="block";
      } else {
          x.style.display="none";
          y.style.display="none";
      }
  }
