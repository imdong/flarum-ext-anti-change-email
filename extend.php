<?php

/*
 * This file is part of imdong/flarum-ext-anti-change-email.
 *
 * Copyright (c) 2023 ImDong.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace ImDong\AntiChangeEmail;

use Flarum\Api\Serializer\UserSerializer;
use Flarum\Extend;
use Flarum\User\Event\Saving;
use Flarum\User\User;
use ImDong\AntiChangeEmail\Common\Defined;

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js'),

    new Extend\Locales(__DIR__ . '/locale'),

    // 控制前端不显示
    (new Extend\ApiSerializer(UserSerializer::class))
        ->attribute('canChangeEmail', function (UserSerializer $serializer, User $user) {
            return $user->can(Defined::key('changeEmail'));
        }),

    // 拦截 修改请求
    (new Extend\Event())
        ->listen(Saving::class, function (Saving $event) {
            $actor = $event->actor;
            $user = $event->user;
            $data = $event->data;

            if (!empty($data['attributes']['email'])) {
                $actor->assertCan(Defined::key('changeEmail'), $user);
            }
        }),
];
