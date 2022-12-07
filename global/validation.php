<?PHP

// This can be used as a min/max, in this regexp,
// the min is 10 and the max is 500:
// /^[\s\S]{10,500}$/

$patterns = array(
	"zip" => generateValidationArray(false, "/^[0-9]{5}$/"),
	"postTitle" => generateValidationArray(true, "/^[\s\S]{10,50}$/", 10, 50),
	"postContent" => generateValidationArray(true, null, 50, 2000),
	"comment" => generateValidationArray(true, null, 10, 500),

	"username" => generateValidationArray(true, "/^[A-Za-z\d]+$/", 3, 20),
	"password" => generateValidationArray(true, "/^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=!]).*$/", 8),
	"new_password" => generateValidationArray(false, "/^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=!]).*$/", 8),
	"firstName" => generateValidationArray(true, "/^[A-Za-z\d?=']+$/", 1, 20),
	"lastName" => generateValidationArray(true, "/^[A-Za-z\d?=']+$/", 1, 30),
	"email" => generateValidationArray(true, "/^[a-zA-Z0-9.!#$%&’*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/"),
	"phone" => generateValidationArray(false, "/^\(?([0-9]{3,4})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/"),
	"birthday" => generateValidationArray(true, "/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/"),

	"quals_degress" => generateValidationArray(false, "/^[\s\S]+$/"),
	"area_of_study" => generateValidationArray(false, "/^[\s\S]+$/"),
	"yearsInField" => generateValidationArray(false, "/^[\s\S]+$/"),
	"secondary_area_of_study" => generateValidationArray(false, "/^[\s\S]+$/"),
	"summary" => generateValidationArray(false, null),
	"about" => generateValidationArray(false, null),

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

		// https://stackoverflow.com/questions/9343082/html5-input-pattern-search-for-quote/12620317#12620317
		$htmlPattern = str_replace("'", '\x27', $htmlPattern);

		$str .= "pattern='{$htmlPattern}' ";
	}
	if ($validation_arr["min"])
		$str .= "minlength='{$validation_arr['min']}' ";
	if ($validation_arr["max"])
		$str .= "maxlength='{$validation_arr['max']}' ";

	return $str;
}
