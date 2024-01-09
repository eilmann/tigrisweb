<?php
session_start();

function loginParticipant($participantID, $participantName) {
    $_SESSION['participantID'] = $participantID;
    $_SESSION['participantName'] = $participantName;
}

function isParticipantLoggedIn() {
    return isset($_SESSION['participantID']);
}

function logoutParticipant() {
    unset($_SESSION['participantID']);
    unset($_SESSION['participantName']);
    session_destroy();
}

function loginAdmin($adminID) {
    $_SESSION['adminID'] = $adminID;
}

function isAdminLoggedIn() {
    return isset($_SESSION['adminID']);
}

function logoutAdmin() {
    unset($_SESSION['adminID']);
    session_destroy();
}

?>