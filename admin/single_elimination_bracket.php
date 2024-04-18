<?php

// Include the database connection file
include('../includes/db.php');
include('../includes/session.php');

// Function to generate single elimination bracket
function generateSingleEliminationBracket($formID, $conn) {
    $bracket = array();

    // Retrieve participant data for the specified formID
    $sql = "SELECT participants.participantID, participants.participantName 
            FROM participants 
            JOIN participant_registrations ON participants.participantID = participant_registrations.participantID 
            WHERE participant_registrations.formID = '$formID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $participants = array();
        while ($row = $result->fetch_assoc()) {
            $participants[] = $row['participantName']; // Add participant names to the array
        }

        // Calculate the number of rounds
        $totalParticipants = count($participants);
        $totalRounds = ceil(log($totalParticipants, 2));

        // Generate matchups for each round
        for ($round = 1; $round <= $totalRounds; $round++) {
            $matches = array();
            $totalMatches = $totalParticipants / pow(2, $round);

            for ($match = 1; $match <= $totalMatches; $match++) {
                $participant1 = isset($participants[($match - 1) * 2]) ? $participants[($match - 1) * 2] : "BYE";
                $participant2 = isset($participants[($match - 1) * 2 + 1]) ? $participants[($match - 1) * 2 + 1] : "BYE";
                $matches[] = array($participant1, $participant2); // Add participants to the match
            }

            $bracket["Round $round"] = $matches;

            // If it's the last round, and there's a bye, add another round for the final match
            if ($round == $totalRounds && $totalParticipants % 2 == 1) {
                $bracket["Final"] = array(array("Winner of Round $round", ""));
            }
        }
    }

    return $bracket;
}

// Check if formID is provided via POST
if(isset($_POST['formID'])) {
    $formID = $_POST['formID'];
    $singleEliminationBracket = generateSingleEliminationBracket($formID, $conn);

    // Display the bracket
    echo "<pre>";
    print_r($singleEliminationBracket);
    echo "</pre>";
} else {
    echo "FormID not provided.";
}

?>
