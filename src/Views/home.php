<?php
/**
 * HOME VIEW TEMPLATE
 * Responsibilities:
 * 1. Display user data in HTML format
 * 2. Maintain IE compatibility
 * 3. Present data from UserController
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <!-- CHARACTER ENCODING -->
        <meta charset="utf-8">
        
        <!-- IE COMPATIBILITY -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <!-- PAGE TITLE -->
        <title>User Listing</title>
        
        <!-- META DESCRIPTION -->
        <meta name="description" content="Displaying user information">
        
        <!-- VIEWPORT CONFIG -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- CSS LINK (currently empty) -->
        <link rel="stylesheet" href="">
    </head>
    <body>
        <!-- USER DATA LOOP -->
        <?php
         
        /**
         * DATA DISPLAY LOGIC
         * - Receives $users array from UserController
         * - Each user contains: Name, Age, Details
         * - Loop generates unordered list for each user
         */
        foreach ($data['users'] as $user): ?>
        
        <ul>

            <li>Name: <?= htmlspecialchars($user['doctor_name'] ?? 'N/A') ?></li>
            <li>General Specilist: <?= htmlspecialchars($user['GenSpec'] ?? 'N/A') ?></li>
            <li>Specific Specilist: <?= htmlspecialchars($user['SpeSpec'] ?? 'N/A') ?></li>
            <li>Hospital: <?= htmlspecialchars($user['Hospital'] ?? 'N/A') ?></li>
            <li>Governorate: <?= htmlspecialchars($user['Gove'] ?? 'N/A') ?></li>
            <li>District: <?= htmlspecialchars($user['District'] ?? 'N/A') ?></li>
            <li>Shift Period: <?= htmlspecialchars($user['Shift_Period'] ?? 'N/A') ?></li>
            <li>Phone Number: <?= htmlspecialchars($user['Phone'] ?? 'N/A') ?></li>
        </ul>

        <?php endforeach; ?>
        

        <!-- EMPTY SCRIPTS SECTION -->
        <script src="" async defer></script>
    </body>
</html>