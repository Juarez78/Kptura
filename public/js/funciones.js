$(document).ready(function () {
  /* Función Cerrar Sesión */
  $("#exit").click(function () {
    alertify.confirm(
      "Login",
      "Seguro/a de cerrar sesión...",
      function () {
        $("#principal").load("./index.php?off=1");
      },
      function () {}
    );
    return false;
  });

  /* Despliega Modals con la lista de los módulos */
  $("#modulos").click(function () {
    $("#ModalModulos").modal("show");
    return false;
  });
});
