<?php

    include_once("../php/db_connect.php");
    $res = $conn->query("SELECT
                            profile.id as 'uid',
                            profile.login as 'login',
                            FIO, 
                            groups.mark as 'group',
                            roles.name as 'role'
                        FROM 
                            profile, groups, roles 
                        WHERE
                            profile.login='{$_COOKIE['login']}' 
                                AND
                            groups.id=profile.groupID
                                AND
                            roles.id=profile.roleID");

    if ($res = $res->fetch_assoc()){
		print_r($res);
    }
?>