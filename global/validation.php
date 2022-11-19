<?PHP

// This can be used as a min/max, in this regexp,
// the min is 10 and the max is 500:
// /^[\s\S]{10,500}$/

$patterns = array(
	"zip" => generateValidationArray(false, "/^[0-9]{5}$/"),
	"postTitle" => generateValidationArray(true, "/^[\s\S]{10,50}$/", 10, 50),
	"postContent" => generateValidationArray(true, "/^[\s\S]{50,2000}$/", 50, 2000),
	"comment" => generateValidationArray(true, "/^[\s\S]{10,500}$/", 10, 500),
);


function generateValidationArray($required, $pattern, $min = null, $max = null)
{
	return array(
		"required" => $required,
		"pattern" => $pattern,
		"min" => $min,
		"max" => $max,
	);
}

function validateInput($validation_arr, $input, $trim = true)
{
	if ($input == null)
		return true;

	if ($trim) $input = trim($input);

	$pattern = $validation_arr["pattern"];
	$min = $validation_arr["min"];
	$max = $validation_arr["max"];

	if ($pattern && !preg_match($pattern, $input))
		return false;
	if ($min && strlen($input) < $min)
		return false;
	if ($max && strlen($input) > $max)
		return false;

	return true;
}

function convertToHTML($validation_arr)
{
	$str = "";

	if ($validation_arr["required"])
		$str .= "required ";
	if ($validation_arr["pattern"]) {
		// Removes the beginning and ending / characters
		$htmlPattern = substr($validation_arr['pattern'], 1, -1);

		$str .= "pattern='{$htmlPattern}' ";
	}
	if ($validation_arr["min"])
		$str .= "minlength='{$validation_arr['min']}' ";
	if ($validation_arr["max"])
		$str .= "maxlength='{$validation_arr['max']}' ";

	return $str;
}
