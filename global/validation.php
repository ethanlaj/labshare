<?PHP

// This can be used as a min/max, in this regexp,
// the min is 10 and the max is 500:
// /^[\s\S]{10,500}$/

$validation_arrs = array(
	"zip" => generate_arr(false, "/^[0-9]{5}$/"),
	"postTitle" => generate_arr(true, "/^[\s\S]{10,50}$/", 10, 50),
	"postContent" => generate_arr(true, null, 50, 2000),
	"comment" => generate_arr(true, null, 10, 500),

	"username" => generate_arr(true, "/^[A-Za-z\d]+$/", 3, 20),
	"password" => generate_arr(true, "/^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=!]).*$/", 8),
	"new_password" => generate_arr(false, "/^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=!]).*$/", 8),
	"firstName" => generate_arr(true, "/^[A-Za-z\d?=']+$/", 1, 20),
	"lastName" => generate_arr(true, "/^[A-Za-z\d?=']+$/", 1, 30),
	"email" => generate_arr(true, "/^[a-zA-Z0-9.!#$%&’*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/"),
	"phone" => generate_arr(false, "/^\(?([0-9]{3,4})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/"),
	"birthday" => generate_arr(true, "/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/"),

	"quals_degress" => generate_arr(false, "/^[\s\S]+$/"),
	"area_of_study" => generate_arr(false, "/^[\s\S]+$/"),
	"yearsInField" => generate_arr(false, "/^[\s\S]+$/"),
	"secondary_area_of_study" => generate_arr(false, "/^[\s\S]+$/"),
	"summary" => generate_arr(false, null),
	"about" => generate_arr(false, null),

);


function generate_arr($required, $pattern, $min = null, $max = null)
{
	return array(
		"required" => $required,
		"pattern" => $pattern,
		"min" => $min,
		"max" => $max,
	);
}

function get_validation_arr($name)
{
	global $validation_arrs;

	if (array_key_exists($name, $validation_arrs))
		return $validation_arrs[$name];
	else
		throw new Error("Invalid validation array");
}

function validate_input($name, $input, $trim = true)
{
	$validation_arr = get_validation_arr($name);

	$required = $validation_arr["required"];
	$pattern = $validation_arr["pattern"];
	$min = $validation_arr["min"];
	$max = $validation_arr["max"];

	if ($input == null) {
		return !$required;
	} else {
		// Input is not null, but could be empty.
		if ($trim) $input = trim($input);

		if (!$input && $required) return false;
	}

	if ($pattern && !preg_match($pattern, $input))
		return false;
	if ($min && strlen($input) < $min)
		return false;
	if ($max && strlen($input) > $max)
		return false;

	return true;
}

function convert_to_html($name)
{
	$validation_arr = get_validation_arr($name);

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
