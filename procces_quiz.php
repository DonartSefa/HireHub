<?php
// Replace with your OpenAI API key
$apiKey = "YOUR_OPENAI_API_KEY";

// Gather answers
$answers = [
  "q1" => $_POST["q1"] ?? '',
  "q2" => $_POST["q2"] ?? '',
  "q3" => $_POST["q3"] ?? ''
];

$prompt = "I am creating a career suggestion quiz. The user answered:\n" .
          "1. Enjoys: {$answers['q1']}\n" .
          "2. Prefers working with: {$answers['q2']}\n" .
          "3. More: {$answers['q3']}\n\n" .
          "Based on this personality, suggest 3 ideal career paths with a short explanation for each.";

// Call GPT API
$ch = curl_init("https://api.openai.com/v1/chat/completions");
$data = [
  "model" => "gpt-4",
  "messages" => [
    ["role" => "system", "content" => "You are a career coach AI. Suggest suitable careers."],
    ["role" => "user", "content" => $prompt]
  ]
];
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json",
  "Authorization: Bearer $apiKey"
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
$advice = $result["choices"][0]["message"]["content"] ?? "Sorry, something went wrong.";

echo "<div class='result'><h2>Your Ideal Careers</h2><p>" . nl2br(htmlspecialchars($advice)) . "</p></div>";
?>
