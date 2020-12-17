<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/PersonasController.php");

use App\Controllers\DepartamentosController;
use App\Controllers\MunicipiosController;
use App\Controllers\PersonasController;
use App\Models\GeneralFunctions;
use App\Models\Personas;

$nameModel = "Persona";
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE']  ?> | Editar <?= $nameModel ?></title>
    <?php require("../../partials/head_imports.php"); ?>
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("../../partials/navbar_customization.php"); ?>

    <?php require("../../partials/sliderbar_main_menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editar <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
                            <li class="breadcrumb-item active">Editar</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensajes de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <?= (empty($_GET['id'])) ? GeneralFunctions::getAlertDialog('error', 'Faltan Criterios de Búsqueda') : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i>&nbsp; Información del <?= $nameModel ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                            data-source="create.php" data-source-selector="#card-refresh-content"
                                            data-load-on-init="false"><i class="fas fa-sync-alt"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                                class="fas fa-expand"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <?php if (!empty($_GET["id"]) && isset($_GET["id"])) { ?>
                                <p>
                                <?php
                                $DataPersona = PersonasController::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataPersona Personas */
                                if (!empty($DataPersona)) {
                                    ?>
                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="frmEdit<?= $nameModel ?>"
                                              name="frmEdit<?= $nameModel ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=edit">
                                            <input id="id" name="id" value="<?= $DataPersona->getId(); ?>" hidden
                                                   required="required" type="text">
                                            <div class="row">
                                                <div class="col-sm-10">
                                                    <div class="form-group row">
                                                        <label for="nombre" class="col-sm-2 col-form-label">Nombres</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="nombre"
                                                                   name="nombre" value="<?= $DataPersona->getNombre(); ?>"
                                                                   placeholder="Ingrese sus nombres">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="apellido" class="col-sm-2 col-form-label">Apellidos</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="apellido"
                                                                   name="apellido" value="<?= $DataPersona->getApellido(); ?>"
                                                                   placeholder="Ingrese sus apellidos">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="tipo_documento" class="col-sm-2 col-form-label">Tipo
                                                            Documento</label>
                                                        <div class="col-sm-10">
                                                            <select id="tipo_documento" name="tipo_documento"
                                                                    class="custom-select">
                                                                <option <?= ($DataPersona->getTipoDocumento() == "CC") ? "selected" : ""; ?>
                                                                        value="CC">Cedula de Ciudadania
                                                                </option>
                                                                <option <?= ($DataPersona->getTipoDocumento() == "CE") ? "selected" : ""; ?>
                                                                        value="CE">Cedula de Extranjeria
                                                                </option>
                                                                <option <?= ($DataPersona->getTipoDocumento() == "TI") ? "selected" : ""; ?>
                                                                        value="TI">Tarjeta de Identidad
                                                                </option>
                                                                <option <?= ($DataPersona->getTipoDocumento() == "NIT") ? "selected" : ""; ?>
                                                                        value="NIT">NIT
                                                                </option>
                                                                <option <?= ($DataPersona->getTipoDocumento() == "REG") ? "selected" : ""; ?>
                                                                        value="REG">Registro Civil
                                                                </option>
                                                                <option <?= ($DataPersona->getTipoDocumento() == "PAS") ? "selected" : ""; ?>
                                                                        value="PAS">Pasaporte
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="documento" class="col-sm-2 col-form-label">Documento</label>
                                                        <div class="col-sm-10">
                                                            <input required type="number" minlength="6" class="form-control"
                                                                   id="documento" name="documento"
                                                                   value="<?= $DataPersona->getDocumento(); ?>"
                                                                   placeholder="Ingrese su documento">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
                                                        <div class="col-sm-10">
                                                            <input required type="number" minlength="6" class="form-control"
                                                                   id="telefono" name="telefono"
                                                                   value="<?= $DataPersona->getTelefono(); ?>"
                                                                   placeholder="Ingrese su telefono">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="rol" class="col-sm-2 col-form-label">Rol</label>
                                                        <div class="col-sm-10">
                                                            <select required id="rol" name="rol" class="custom-select">
                                                                <option <?= ($DataPersona->getRol() == "Administrador") ? "selected" : ""; ?> value="Administrador">Administrador</option>
                                                                <option <?= ($DataPersona->getRol() == "Proveedor") ? "selected" : ""; ?> value="Proveedor">Proveedor</option>
                                                                <option <?= ($DataPersona->getRol() == "Cliente") ? "selected" : ""; ?> value="Cliente">Cliente</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="municipio_id" class="col-sm-2 col-form-label">Municipio</label>
                                                        <div class="col-sm-5">
                                                            <?= DepartamentosController::selectDepartamentos(
                                                                array(
                                                                    'id' => 'departamento_id',
                                                                    'name' => 'departamento_id',
                                                                    'defaultValue' => (!empty($DataPersona)) ? $DataPersona->getMunicipio()->getDepartamento()->getId() : '15',
                                                                    'class' => 'form-control select2bs4 select2-info',
                                                                    'where' => "estado = 'Activo'"
                                                                )
                                                            )
                                                            ?>
                                                        </div>
                                                        <div class="col-sm-5 ">
                                                            <?= MunicipiosController::selectMunicipios(
                                                                array (
                                                                    'id' => 'municipio_id',
                                                                    'name' => 'municipio_id',
                                                                    'defaultValue' => (!empty($DataPersona)) ? $DataPersona->getMunicipioId() : '',
                                                                    'class' => 'form-control select2bs4 select2-info',
                                                                    'where' => "departamento_id = ".$DataPersona->getMunicipio()->getDepartamento()->getId()." and estado = 'Activo'")
                                                            )
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="direccion" class="col-sm-2 col-form-label">Direccion</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="direccion"
                                                                   name="direccion" value="<?= $DataPersona->getDireccion(); ?>"
                                                                   placeholder="Ingrese su direccion">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input required type="email" class="form-control" id="email"
                                                                   name="email" value="<?= $DataPersona->getEmail(); ?>"
                                                                   placeholder="Ingrese su Email">
                                                        </div>
                                                    </div>
                                                    <?php if ($_SESSION['UserInSession']['rol'] == 'Administrador'){ ?>
                                                        <div class="form-group row">
                                                            <label for="user" class="col-sm-2 col-form-label">Usuario</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="user" name="user" value="<?= $DataPersona->getUser(); ?>" placeholder="Ingrese su Usuario">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                                                            <div class="col-sm-10">
                                                                <input type="password" class="form-control" id="password" name="password" value="<?= $DataPersona->getPassword(); ?>" placeholder="Ingrese su Password">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                                            <div class="col-sm-10">
                                                                <select required id="estado" name="estado" class="custom-select">
                                                                    <option <?= ($DataPersona->getEstado() == "Activo") ? "selected" : ""; ?> value="Activo">Activo</option>
                                                                    <option <?= ($DataPersona->getEstado() == "Inactivo") ? "selected" : ""; ?> value="Inactivo">Inactivo</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <hr>
                                            <button type="submit" class="btn btn-info">Enviar</button>
                                            <a href="index.php" role="button" class="btn btn-default float-right">Cancelar</a>
                                        </form>
                                    </div>
                                    <!-- /.card-body -->

                                <?php } else { ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                        No se encontro ningun registro con estos parametros de
                                        busqueda <?= ($_GET['mensaje']) ?? "" ?>
                                    </div>
                                <?php } ?>
                                </p>
                            <?php } ?>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require('../../partials/footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php require('../../partials/scripts.php'); ?>
<script>
    $(function() {
        $('#departamento_id').on('change', function() {
            $.post("../../../app/Controllers/MainController.php?controller=Municipios&action=selectMunicipios", {
                isMultiple: false,
                isRequired: true,
                id: "municipio_id",
                nombre: "municipio_id",
                defaultValue: "",
                class: "form-control select2bs4 select2-info",
                where: "departamento_id = "+$('#departamento_id').val()+" and estado = 'Activo'",
                request: 'ajax'
            }, function(e) {
                if (e)
                    console.log(e);
                $("#municipio_id").html(e).select2({ height: '100px'});
            })
        });
        $('#foto').on("change", function(){
            $( "#thumbFoto" ).remove();
        });
    });
</script>
</body>
</html>
