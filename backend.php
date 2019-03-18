<?php
$responseObject = new stdClass();
try {

//sanitize input
    $personCount = isset($_POST['person_no']) ? $_POST['person_no'] : null;

    //validate input
    if ($personCount < 0 || $personCount == null || !is_numeric($personCount)) {

        //prepare exception response for error to frontend
        $responseObject->status = "Error";
        $responseObject->message = "Input value does not exist or value is invalid";
        echo json_encode($responseObject);
        exit;
    }

    // if ($personCount == 0) {
    //     throw new Exception("Irregularity occurred");
    // }

    //building cards
    $types = array('S', 'H', 'D', 'C');

    $values = array('A', '2', '3', '4', '5', '6', '7', '8', '9', 'X', 'J', 'Q', 'K');

    $cards = array();

    foreach ($types as $type) {

        foreach ($values as $value) {

            array_push($cards, $type . '-' . $value);
        }

    }

//prepare persons hands
    $personCards = array();

//shuffle cards
    shuffle($cards);

//distribute cards to each persons hands

    $currentCard = 0;
    //check if person count zero
    if ($personCount != 0) {
        while ($currentCard < sizeof($cards)) {
            for ($j = 0; $j < $personCount; $j++) {
                if (isset($personCards[$j])) {
                    $personCards[$j] = $personCards[$j] . ", " . $cards[$currentCard];
                } else {
                    $personCards[$j] = $cards[$currentCard];
                }
                $currentCard++;

                //stop once all card distributed
                if ($currentCard == sizeof($cards)) {
                    break;
                }
            }
        }
    }

    //prepare response for success to frontend
    $responseObject->data = $personCards;
    $responseObject->status = "Success";
    $responseObject->message = "Success";
    echo json_encode($responseObject);

} catch (Exception $e) {

    //prepare exception response for error to frontend
    $responseObject->status = "Error";
    $responseObject->message = $e->getMessage();
    echo json_encode($responseObject);
    exit;
}
