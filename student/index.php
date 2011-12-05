<html>
<head>
    <title> Instructor Home </title>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jq
uery-ui.css" rel="stylesheet" type="text/css"/>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.j
s'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui
.min.js'></script>
    <link rel="stylesheet" type="text/css" href="../css/dateStyle.css" />
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body>
        <div id="message">
                <?php
                if ( !empty( $_POST['message'] ) )
                        echo '<p>' . $_POST['message'] . '</p>';
                ?>
        </div>
        <div id="header">
                <h1> Student Home </h1>
        </div>
        <div id="menu">
                <?php include ("../includes/instruct_menu.php"); ?>
        </div>

        <div id="content">
                <div id="projectSelect">
                        <form id='projectForm' name="instructorHome"
                                action="index.php" method="post" >
                        <?php
                        echo '<p> Class ' . $_SESSION['crsID'] . ' is selected,change course? </p>';
                        ?>
                        <select id='classSelect' name='classSelect' onchange='this.form.submit()'>
                                <?php
                                for ( $i = 1; $i <= 2; $i++ ) {
                                        if ( $i == $_SESSION['crsID'] )
                                                $defaultString = 'selected="selected"';
                                        else $defaultString = '';
                                        echo '<option value="' . $i . '" ' . $defaultString . '> Course ' . $i . '</option>';
                                }
                                ?>
                        </select>
                        <?php
                        if ( !empty( $prjName ) ) {
                                echo '<p> Project ' . $prjName . ' selected, change project? </p>';
                        }
                        else {
                                echo '<p> Select a project to work on</p>';
                        }
                        ?>

                        <select id='projectSelect' name='projectSelect'
                                <?php if (empty($_SESSION['crsID'])) echo 'disabled="disabled"'?> onchange='this.form.submit()'>
                                <?php // Compile a list of all projects for this class
                                foreach ( $project as $prj ) {
                                        print_r ($prj);
                                        if ( $prj['prjID'] == $_SESSION['prjID']
 )
                                                $defaultString = 'selected="selected"';
                                        else $defaultString = '';
                                        echo '<option value="' . $prj['prjID'] . '" ' . $defaultString . '>' . $prj['prjName'] . ' </option>';
                                }
                                if ( empty ( $_SESSION['prjID'] ) )
                                        echo '<option selected="selected"> Select a project </option>';
                                ?>
                        </select>

                        </form>
                        <input id='submit' type="submit" style="visibility:hidden" />

                </div>
        </div>
</body>
</html>

