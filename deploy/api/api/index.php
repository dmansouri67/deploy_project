<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Tuupola\Middleware\HttpBasicAuthentication;
use \Firebase\JWT\JWT;
require __DIR__ . '/../vendor/autoload.php';
 
const JWT_SECRET = "makey1234567";

$app = AppFactory::create();

//Create JWT token
function createJWT(Response $response)
{
    $issuedAt = time();
    $expirationTime = $issuedAt + 60; // jwt valid for 60 seconds from the issued time
    $key = JWT_SECRET;
    $payload = array(
        'userid' => '1',
        'email' => 'dmansouri396@gmail.com',
        'pseudo' => 'dmansouri',
        'iat' => $issuedAt,
        'exp' => $expirationTime
    );
    $jwt = JWT::encode($payload, $key);
    $response->getBody()->write($jwt);
    return $response;
}

//Verify JWT token
function verifyJWT(Request $request, Response $response, $next)
{
    $token = $request->getHeader('Authorization')[0];
    $key = JWT_SECRET;
    try {
        $decoded = JWT::decode($token, $key, array('HS256'));
        $response = $next($request, $response);
        return $response;
    } catch (\Exception $e) {
        $response->getBody()->write('Access denied');
        return $response->withStatus(401);
    }
}

function addHeaders(Response $response)
{
    $response = $response->withHeader('Content-type', 'application/json')
                         ->withHeader('Access-Control-Allow-Origin', 'https://webservice2-qcwd.onrender.com')
                         ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                         ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                         ->withHeader('Access-Control-Expose-Headers', 'Authorization');
    return $response;
}


//#################### ROUTES ####################
$app->post('/api/login', function (Request $request, Response $response) {

    $body = $request->getParsedBody();
    $login = $body['login'] ?? "";
    $password = $body['password'] ?? "";

    $err = $login == "" || $password == "";
    if ($err) {
        $donnees["error"] = "Error";
        $response = $response->withStatus(403);
        $response->getBody()->write(json_encode($donnees, JSON_UNESCAPED_SLASHES));
        return $response;
    }

    $repClient = Config::getInstance()->entityManager->getRepository('client');
    $clientLogin = $repClient->findOneBy(array("login" => $login));

    if ($clientLogin == null || password_verify($password, $clientLogin->getPassword()) == false) {
        $donnees["error"] = "Error";
        $response = $response->withStatus(403);
        $response->getBody()->write(json_encode($donnees, JSON_UNESCAPED_SLASHES));
        return $response;
    }
    // Getters des infos du compte
    $donnees["email"] = $clientLogin->getEmail();
    $donnees["login"] = $clientLogin->getLogin();
    $donnees["prenom"] = $clientLogin->getPrenom();
    $donnees["nom"] = $clientLogin->getNom();
    $response = addHeaders($response);
    $response = createJWT($response, $login);
    $response->getBody()->write(json_encode($donnees, JSON_UNESCAPED_SLASHES));
    return $response;



    // $err=false;
    // $inputJSON = file_get_contents('php://input');
    // $body = json_decode($inputJSON, TRUE); //convert JSON into array
    // $email = $body['email'];
    // $password = $body['password'];
    // if ($email == 'dmansouri396@gmail.com' && $password == '123456') {
    //     $response = createJWT($response);
    // } else {
    //     $err=true;
    //     $response->getBody()->write('Access denied');
    // }

    // if (empty($email) || empty($password)|| !preg_match("/^[a-zA-Z0-9]+$/", $login) || !preg_match("/^[a-zA-Z0-9]+$/", $password)) {
    //     $err=true;
    // }

    // if (!$err) {
    //     $response = addHeaders($response);
    //     $response = createJWT($response);
    //     $response->getBody()->write('Access granted');
    // }
    // else{
    //     $response = $response->withStatus(401);
    // }
    // return $response;
});


// $app->get('/api/hello/{name}', function (Request $request, Response $response, $args) {
//     $array = [];
//     $array ["nom"] = $args ['name'];
//     $response->getBody()->write(json_encode ($array));
//     return $response;
// });

// $app->get('/api/user', function (Request $request, Response $response) {
//     $array = [];
//     $array ["nom"] = "mansouri";
//     $array ["prenom"] = "dalila";
//     $array ["email"] = "dmansouri396@gmail.com";
//     $response = addHeaders($response);
//     $response->getBody()->write(json_encode ($array));
//     return $response;
// });

// $app->get('/api/user/{id}', function (Request $request, Response $response, $args) {
//     $array = [];
//     $array ["nom"] = "mansouri";
//     $array ["prenom"] = "dalila";
//     $array ["email"] = "dmansouri396@gmail.com";
//     $response = addHeaders($response);
//     $response->getBody()->write(json_encode ($array));
//     return $response;
// });


$app->get('/api/products', function (Request $request, Response $response) {
    $json = file_get_contents('./mock/product.json');
    $response = addHeaders($response);
    $response->getBody()->write($json);
    return $response;
});

$app->get('/api/products/{id}', function (Request $request, Response $response, $args) {
    $json = file_get_contents('./mock/product.json');
    $array = json_decode($json, true);
    $response = addHeaders($response);
    $response->getBody()->write(json_encode($array[$args['id']]));
    return $response;
});

$app->post('/api/products', function (Request $request, Response $response) {
    $inputJSON = file_get_contents('php://input');
    $body = json_decode($inputJSON, TRUE); //convert JSON into array
    $race[] = $body ['race'];
    $region[] = $body ['region'];
    $taille[] = $body ['taille'];
    $err=false;

    if (empty($race) || empty($region) || empty($taille)) {
        $err=true;
    }

    if (!$err) {
        $json = file_get_contents('./mock/product.json');
        $array = json_decode($json, true);
        $id = count($array);
        $array[] = array('id' => $id, 'race' => $race, 'region' => $region, 'taille' => $taille);
        $json = json_encode($array);
        file_put_contents('./mock/product.json', $json);
        $response = addHeaders($response);
        $response->getBody()->write('Access granted');
    }
    else{
        $response = $response->withStatus(401);
    }

    $response = addHeaders($response);
    $response->getBody()->write(json_encode($array));
    return $response;
});

$app->put('/api/products/{id}', function (Request $request, Response $response, $args) {
    $inputJSON = file_get_contents('php://input');
    $body = json_decode($inputJSON, TRUE); //convert JSON into array
    $race[] = $body ['race'];
    $region[] = $body ['region'];
    $taille[] = $body ['taille'];
    $err=false;

    if (empty($race) || empty($region) || empty($taille)) {
        $err=true;
    }

    if (!$err) {
        $json = file_get_contents('./mock/product.json');
        $array = json_decode($json, true);
        $array[$args['id']] = array('id' => $id, 'name' => $name, 'region' => $region, 'taille' => $taille);
        $json = json_encode($array);
        file_put_contents('./mock/product.json', $json);
        $response = addHeaders($response);
        $response->getBody()->write('Access granted');
    }
    else{
        $response = $response->withStatus(401);
    }

    return $response;
});

$app->delete('/api/products/{id}', function (Request $request, Response $response, $args) {
    $json = file_get_contents('./mock/product.json');
    $array = json_decode($json, true);
    unset($array[$args['id']]);
    $json = json_encode($array);
    file_put_contents('./mock/product.json', $json);
    $response = addHeaders($response);
    $response->getBody()->write('Access granted');
    return $response;
});

// $options = [
//     "attribute" => "token",
//     "header" => "Authorization",
//     "regexp" => "/Bearer\s+(.*)$/i",
//     "secure" => false,
//     "algorithm" => ["HS256"],
//     "secret" => JWT_SECRET,
//     "path" => ["/api"],
//     "ignore" => ["/api/hello"],
//     "error" => function ($response, $arguments) {
//         $data = array('ERREUR' => 'Connexion', 'ERREUR' => 'JWT Non valide');
//         $response = $response->withStatus(401);
//         return $response->withHeader("Content-Type", "application/json")->getBody()->write(json_encode($data));
//     }
// ];

$app->add(new Tuupola\Middleware\JwtAuthentication($options));
$app->run ();
