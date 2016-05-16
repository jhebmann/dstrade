<?php
include('../includes/cookie.php');
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    
    <link rel="icon" href="../lib/favicon.png" type="image/png" sizes="32x32">
    <title>My profile</title>
</head>
<body>
<?php include('../includes/menu.php');
if (!$connected){ ?>
<h1>~ DSTrade ~</h1>
<p>You're not logged in !</p>
<p>Log in <a href="../login">Here</a> or register <a href="../register">Here</a> !</p>
</body>
<?php
} else {
    ?>
    <h1>My profile</h1>
    <div id="user_infos" class="profilediv">
        <h2 class="deployable">User informations</h2>
        <p>Username : <?php echo $user_infos['username']; ?></p>
        <p>Email address : <?php echo $user_infos['email']; ?></p>
        <p>Steam64 ID
            : <?php if ($user_infos['steam64id'] != NULL) echo $user_infos['steam64id']; else print("Not filled ! Click <a href='update'>Here</a> to update your profile !"); ?></p>
        <p>Edit your informations <a href='update'>Here</a></p>
    </div>
    <div id="account_infos" class="profilediv">
        <h2 class="deployable">Account informations</h2>
        <p>Vipoints : <?php echo $user_infos['vipoints']; ?> (Buy souls and get vipoints <a href='../buy'>Here</a>)</p>
        <p>Souls : <?php echo $user_infos['souls']; ?> (Buy souls <a href='../buy'>Here</a>)</p>
        <p>Member since : <?php echo $user_infos['creation_date']; ?></p>
    </div>
    <div id="game_infos" class="profilediv">
        <h2 class="deployable">Game informations</h2>
        <p>Character Soul Level
            : <?php print($user_infos['sl'] . ", You can change it <a href='character'>Here</a>."); ?></p>

        <?php
        /*
        <p>Items :
            <?php
            $sql = "SELECT NAME, POSSESS.QUANTITY FROM POSSESS, ITEM WHERE ID_USER = " . $user_infos['id'] . " AND ID_ITEM = ID;";
            if (($requete = $bdd->query($sql)) != FALSE) {
                $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
                if (sizeof($resultats) == 0) {
                    print("You don't seem to have any item ! You can declare some <a href='character'>Here</a>");
                } else {
                    $string = "";
                    foreach ($resultats as $resultat) {
                        $string .= $resultat['quantity'] . " x " . $resultat['name'] . ", ";
                    }
                    $string = rtrim($string, ", ");
                    $string .= "<br>You can change them <a href='character'>Here</a>";
                    echo $string;
                }
            } else {
                header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
            }
            ?>
        </p>
        */
        ?>
        <p>Current trade offers :</p>
        <?php
        $sql = "SELECT * FROM TRADE WHERE IDUSER1 = " . $user_infos['id'] . " AND STATE='OFFER';";
        if (($requete = $bdd->query($sql)) != FALSE) {
            $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
            if (sizeof($resultats) == 0) {
                print("<p>You don't seem to have any current trade offer ! You can declare one <a href='../trade/new'>Here</a></p>");
            } else {
                $string = "";
                $ids = ['iditem1_1', 'iditem1_2', 'iditem1_3', 'iditem2_1', 'iditem2_2', 'iditem2_3'];
                $quantities = ['quantity1_1', 'quantity1_2', 'quantity1_3', 'quantity2_1', 'quantity2_2', 'quantity2_3'];
                foreach ($resultats as $resultat) {
                    foreach ($ids as $key => $id) {
                        if ($resultat[$id] != NULL) {
                            $sql = "SELECT NAME FROM ITEM WHERE ID = " . $resultat[$id] . ";";
                            if (($requete = $bdd->query($sql)) != FALSE) {
                                $resultats2 = $requete->fetchAll(PDO::FETCH_ASSOC);
                                if ($key < 3) {
                                    $string .= "<p>You're offering : " . $resultats2[0]['name'] . " x " . $resultat[$quantities[$key]] . " ; ";
                                    $string = str_replace(" ; <p>You're offering : ", ", ", $string);
                                } else {
                                    $string .= "You're searching for : " . $resultats2[0]['name'] . " x " . $resultat[$quantities[$key]] . ", ";
                                    $string = str_replace(", You're searching for : ", ", ", $string);
                                }
                            } else {
                                header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
                            }
                        }
                    }
                    $string = rtrim($string, ", ");
                    $string .= " <a class='btn' href='../trade/edit?id=" . $resultat['id'] . "'>EDIT</a><a class='btn' href='../trade/delete?id=" . $resultat['id'] . "'>DELETE</a></p>";
                }

                $string = rtrim($string, ", ");
                echo $string;
            }
        } else {
            header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
        }

        $sql = "SELECT * FROM TRADE WHERE (IDUSER1 = " . $user_infos['id'] . " OR IDUSER2 = " . $user_infos['id'] . ") AND STATE='ACCEPTED';";
        if (($requete = $bdd->query($sql)) != FALSE) {
            $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
            if (sizeof($resultats) == 0) {
                print("<p>You don't seem to have any accepted trade ! You can declare one <a href='../trade/new'>Here</a> or search for one <a href='../trade/browse'>Here</a>.</p>");
            } else {
                $string = "<p>Accepted and pending trades :</p>";
                $ids = ['iditem1_1', 'iditem1_2', 'iditem1_3', 'iditem2_1', 'iditem2_2', 'iditem2_3'];
                $quantities = ['quantity1_1', 'quantity1_2', 'quantity1_3', 'quantity2_1', 'quantity2_2', 'quantity2_3'];
                foreach ($resultats as $resultat) {
                    $isuser1 = ($user_infos['id'] == $resultat['iduser1']);
                    foreach ($ids as $key => $id) {
                        if ($resultat[$id] != NULL) {
                            $sql = "SELECT NAME FROM ITEM WHERE ID = " . $resultat[$id] . ";";
                            if (($requete = $bdd->query($sql)) != FALSE) {
                                $resultats2 = $requete->fetchAll(PDO::FETCH_ASSOC);
                                if ($key < 3) {
                                    if ($isuser1) {
                                        $string .= "<p>You'll offer : " . $resultats2[0]['name'] . " x " . $resultat[$quantities[$key]] . " ; ";
                                        $string = str_replace(" ; <p>You'll offer : ", ", ", $string);
                                    }
                                    else{
                                        $string .= "<p>You'll get : " . $resultats2[0]['name'] . " x " . $resultat[$quantities[$key]] . " ; ";
                                        $string = str_replace(" ; <p>You'll get : ", ", ", $string);
                                    }
                                } else {
                                    if ($isuser1) {
                                        $string .= "You'll get : " . $resultats2[0]['name'] . " x " . $resultat[$quantities[$key]] . ", ";
                                        $string = str_replace(", You'll get : ", ", ", $string);
                                    }else{
                                        $string .= "You'll offer : " . $resultats2[0]['name'] . " x " . $resultat[$quantities[$key]] . ", ";
                                        $string = str_replace(", You'll offer : ", ", ", $string);
                                    }
                                }
                            } else {
                                header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
                            }
                        }
                    }
                    $string = rtrim($string, ", ");
                }

                $string = rtrim($string, ", ");
                echo $string;
            }
        } else {
            header('Location: ../error?src=' . $_SERVER['REQUEST_URI']);
        }
        ?>
    </div>
    <script>
        $(".deployable").click(function(){
            $(this).siblings().each(function(index){
                $(this).delay(300*index).toggle(350);
            });
        });
    </script>
    </body>
    <?php
}
?>
</html>
