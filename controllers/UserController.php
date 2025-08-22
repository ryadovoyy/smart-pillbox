<?php

namespace app\controllers;

use app\models\User;
use DateTimeImmutable;
use DateTimeZone;
use Yii;
use yii\base\DynamicModel;
use yii\rest\Controller;
use yii\web\UnauthorizedHttpException;

class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'login' => ['POST'],
        ];
    }

    public function actionLogin()
    {
        $requestBody = Yii::$app->request->bodyParams;

        $email = $requestBody['email'] ?? null;
        $password = $requestBody['password'] ?? null;

        $validator = new DynamicModel(['email' => $email, 'password' => $password]);

        $validator
            ->addRule(['email', 'password'], 'required')
            ->addRule(['email', 'password'], 'string')
            ->validate();

        if ($validator->hasErrors()) {
            return $validator;
        }

        $user = User::findByEmail($email);

        if (!$user || !$user->validatePassword($password)) {
            throw new UnauthorizedHttpException('Invalid login credentials.');
        }

        $now = new DateTimeImmutable('now', new DateTimeZone(Yii::$app->timeZone));

        $token = Yii::$app->jwt->getBuilder()
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now)
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('uid', $user->id)
            ->getToken(
                Yii::$app->jwt->getConfiguration()->signer(),
                Yii::$app->jwt->getConfiguration()->signingKey()
            );

        $tokenString = $token->toString();

        return [
            'token' => $tokenString,
            'user' => $user,
        ];
    }
}
