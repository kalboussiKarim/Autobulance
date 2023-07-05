<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>

<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">

    <tr>
        <td align="center" style="padding:40px 0 30px 0;background:#70bbd9;">
            <h2 style="color:white;">Registration</h2>
        </td>
    </tr>
    <tr>
        <td style="padding:36px 30px 42px 30px;">
            <p>Dear Mr./Ms. {{ $mailData['name']}}</p>
            <h5>These are is your login credentials:</h5>
            <h4>Your email address: {{ $mailData['email'] }}</h4>
            <h4>Your password: {{ $mailData['password'] }}</h4>
            <p>Do not give these informations to anyone.</p>
            <p>Thank you.</p>

        </td>
    </tr>
    <tr>
        <td align="center">
            <div>
                <button style=" padding: 10px; background:#70bbd9;border-radius :10px; border-color:white"><a style="color:white;" href="https://www.google.com">Log in</a></button>
            </div>
        </td>
    </tr>
    <tr>
        <p></p>
    </tr>
    <tr>
        <td align="center" style="padding:20px 0 20px 0;background:#70bbd9;">
        </td>
    </tr>

</table>

</body>

</html>