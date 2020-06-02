<?php
    include_once 'classes/Session.php';
    Session::start();
    if(!isset($_SESSION['id']) && Session::get('role') != 'Student'){
        exit();
    }
    include_once "classes/Students.php";
    include_once "classes/Users.php";

if(isset($_POST['fname'])){
        $imgArr = $_FILES['profile']; 
        $user = new Users();
        $user->setFname($_POST['fname']);
        $user->setLname($_POST['lname']);
        $user->setDob(date('Y-m-d',strtotime($_POST['dob'])));
        $user->setGender($_POST['gender']);
        $user->setMobile($_POST['mobile']);
        $user->setAddress($_POST['address']);
        $user->setQuestion($_POST['question']);
        $user->setAnswer($_POST['answer']);
        $student = new Students();
        $student->setId(Session::get('id'));
        $student->setRoll_no($_POST['roll_no']);
        $student->setBranch($_POST['branch']);
        $student->setSemester($_POST['semester']);
        $student->setStart_year($_POST['start_year']);
        $student->setEnd_year($_POST['end_year']);
        $student->editByStudent($imgArr,$user);
}
    $student = new Students();
    $student->setId(Session::get('id'));
    $result = $student->getStudent();
    if($result->num_rows <= 0){
        $type = "warning";
            $msg = "<strong>Warning !</strong> No record found !";
            Session::setMessage($type, $msg);
    }
    include_once 'common.php';
    $studentlist="active";
include  "header.php" ?>
<link rel="stylesheet" href="css/header.css" >
<!-- Start Feature Section -->
        <section id="feature" class="feature-section first-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <?php if($result->num_rows > 0){
                             $row = $result->fetch_assoc();
                             if($row['imgurl'] != ""){
                                 $imgurl = "profile/".$row['imgurl'];
                             }else{
                                 $imgurl = "profile/profile.png";
                             }
                            ?>
                        <div class="welcome-section">
                            <img class="img-circle" src="<?php echo $imgurl; ?>" >
                            <h4 class="text-center">
                                <?php echo $row['fname']." ".$row['lname']; ?>
                            </h4>
                            <div class="border"></div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="welcome-section">
                                <h4 class="text-center"> Edita tu regsitro </h4> 
                                <div class="border"></div>
                                <br/>
                                <?php echo Session::getMessage();?>
                                <?php if($result->num_rows > 0){ 
                                    ?>
                                    <form  enctype="multipart/form-data" method="post">
                                            <div class="form-group">
                                                <label>Número de Matrícula</label>
                                                <input type="text" name="roll_no"  class="form-control" value="<?php echo $row['roll_no']; ?>" data-validate="required" >
                                            </div>
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input type='text' name="fname" class="form-control" value='<?php echo $row['fname']; ?>' />
                                        </div>
                                        <div class="form-group">
                                            <label>Apellido</label>
                                            <input type='text' name="lname" class="form-control" value='<?php echo  $row['lname']; ?>' />
                                        </div>
                                    <div class="form-group">
                                        <label>Número Celular</label>
                                        <input type="text" name="mobile" class="form-control" name="mobile" value="<?php echo $row['mobile'] ?>" id="mobile" data-validate="required,mobileNumber" placeholder="Mobile Number *">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control date datepicker"  data-provide="datepicker" value="<?php echo date('d-m-Y' ,strtotime($row['dob'])); ?>" data-date-format="dd-mm-yyyy" name="dob" id="dob" data-validate="required" placeholder="Fecha de Nacimiento *">
                                    </div> 
                                    <div class="form-group">
                                        <label>Género</label>
                                        <input type="radio" name="gender"  value="Male"  <?php if($row['gender'] == "Male") echo "checked"; ?>> Hombre &nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="gender"  value="Female"  <?php if($row['gender'] == "Female") echo "checked"; ?>> Mujer 
                                    </div>
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <textarea name="address" class="form-control" id="address" placeholder="Dirección"><?php echo $row['address'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Facultad</label>
                                        <select class="form-control" name="branch" data-validate="required">
                                            <option value="">-- Seleccione --</option>
                                            <option value='CSE' <?php if($row['branch'] == "CSE") echo "selected"?>>CSE</option>
                                            <option value='IT' <?php if($row['branch'] == "IT") echo "selected"?>>IT</option>
                                            <option value='ME' <?php if($row['branch'] == "ME") echo "selected"?>>ME</option>
                                            <option value='CIVIL' <?php if($row['branch'] == "CIVIL") echo "selected"?>>CIVIL</option>
                                            <option value='EC' <?php if($row['branch'] == "EC") echo "selected"?>>EC</option>
                                        </select>
                                    </div>
                                        <div class="form-group">
                                            <label>Semestre</label>
                                            <select class="form-control" name="semester" data-validate="required">
                                                <option value="">-- Seleccione --</option>
                                                <option value='Primero' <?php if($row['semester'] == "Primero") echo "selected"?>>Primer Semestre</option>
                                                <option value='Segundo' <?php if($row['semester'] == "Segundo") echo "selected"?>>Segundo Semestre</option>
                                                <option value='Tercero' <?php if($row['semester'] == "Tercero") echo "selected"?>>Tercer Semestre</option>
                                                <option value='Cuarto' <?php if($row['semester'] == "Cuarto") echo "selected"?>>Cuarto Semestre</option>
                                                <option value='Quinto' <?php if($row['semester'] == "Quinto") echo "selected"?>>Quinto Semestre</option>
                                                <option value='Sexto' <?php if($row['semester'] == "Sexto") echo "selected"?>>Sexto Semestre</option>
                                                <option value='Séptimo' <?php if($row['semester'] == "Séptimo") echo "selected"?>>Séptimo Semestre</option>
                                                <option value='Octavo' <?php if($row['semester'] == "Octavo") echo "selected"?>>Octavo Semestre</option>
                                                <option value='Noveno' <?php if($row['semester'] == "Noveno") echo "selected"?>>Noveno Semestre</option>
                                                <option value='Décimo' <?php if($row['semester'] == "Decimo") echo "selected"?>>Décimo Semestre</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Año de Inicio</label>
                                            <select class="form-control" name="start_year" data-validate="required">
                                                <option value="">-- Año Inicio --</option>
                                                <?php for($i=2000;$i <= 2050;$i++){ ?>
                                                        <option <?php if($row['start_year'] == $i) echo "selected" ?> value='<?php echo $i; ?>'><?php echo $i; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Año de Finalización</label>
                                            <select class="form-control" name="end_year" data-validate="required">
                                                <option value="">-- Año Fin --</option>
                                                <?php for($i=2000;$i <= 2050;$i++){ ?>
                                                        <option <?php if($row['end_year'] == $i) echo "selected" ?> value='<?php echo $i; ?>'><?php echo $i; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Seleccione Pregunta</label>
                                            <select class="form-control" name="question" data-validate="required">
                                                <option value="">-- Select Question --</option>
                                                <option value='1' <?php if($row['question'] == 1) echo "selected"; ?>>Nombre de tu primer colegio</option>
                                                <option value='2' <?php if($row['question'] == 2) echo "selected"; ?>>Nombre de tu restaurante favorito</option>
                                                <option value='3' <?php if($row['question'] == 3) echo "selected"; ?>>Nombre de tu actor favorito</option>
                                                <option value='4' <?php if($row['question'] == 4) echo "selected"; ?>>Tu película favorita</option>
                                                <option value='5' <?php if($row['question'] == 5) echo "selected"; ?>>Nombre de la persona que admiras</option>>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Respuesta</label>
                                            <input type="answer" class="form-control" name="answer" value="<?php echo $row['answer']; ?>" id="answer" data-validate="required" placeholder="Answer *">
                                        </div>
                                        <div class="form-group">
                                            <label>Selecciona foto de perfil</label>
                                            <input type="file" class="form-control" name="profile" id="profile"  >
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="editstudent" class="btn btn-primary" id="editStudent" value="editstudent"><strong>Actualizar</strong></button>
                                        </div>
                                </form>
                                <br/>
                                <?php } ?>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div>
        </section>
<?php include "footer.php"; ?>