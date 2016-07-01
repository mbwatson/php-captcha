# PHP CAPTCHA

## Image generation

To generate image containing captcha text, make the following call.

      `$_SESSION['captcha'] = generateRandomString([length],[string]);`

The function `generateRandomString` takes two parameters:

- the first parameter indicates the length string to be generated
- the second parameter indicates the characters used in the CAPTCHA generation

For example,
`$_SESSION['captcha'] = generateRandomString(4,'1234567890');`
generates a string of length four that contains only values from the set {"1", "2", "3", "4", "5", "6", "7", "8", "9", "0"}.

The call `$_SESSION['captcha'] = generateRandomString(6,'01');` will generate a binary string of length six.

## Seeing the Image

Use the following html to display the generated image on desired page with the following IMG tag.

`<img class="captcha" src="captcha.php" alt="CAPTCHA security code" />`
