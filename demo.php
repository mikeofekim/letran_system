<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<script src='https://meet.jit.si/external_api.js'></script>
<div id="meet"></div>
<script>
    const domain = 'meet.jit.si';
    const options = {
        roomName: 'iConsult',
        width: window.width,
        height: window.innerHeight,
        parentNode: document.querySelector('#meet'),
        userInfo: {

            displayName: 'John Doe'
        }
    };
    const api = new JitsiMeetExternalAPI(domain, options);
</script>

<body>

</body>

</html>