<?php

return [
    'dashboard:title' => 'ダッシュボード',

    'profile:title'   => 'プロフィール',
    'profile:update:title' => '基本情報更新',
    'profile:update:desc' => '名前・メールアドレスなど基本情報を更新します。',
    'profile:update:photo' => 'プロフィール写真',
    'profile:update:photo:select' => 'イメージを選択',
    'profile:update:photo:remove' => 'イメージを削除',

    'profile:password:title' => 'パスワード更新',
    'profile:password:desc' => 'ログイン用パスワードを変更します。',
    'profile:password:current' => '現在のパスワード',
    'profile:password:new' => '新しいパスワード',
    'profile:password:new_confirm' => '新しいパスワード（確認用）',

    'profile:loginsession:title' => 'ログインセッション',
    'profile:loginsession:desc' => 'アプリケーションにより管理されている端末から、強制的にログアウトを行います。',
    'profile:loginsession:explain' => '不正なアクセスなどからアカウントを守るため、現在ログインしている全ての端末からログアウトを行います。実際にアカウントへの不審なアクティビティがある場合は、パスワードリセットをお勧めします。',
    'profile:loginsession:execute' => '全ての端末からログアウトする',
    'profile:loginsession:execute_password' => '処理の実行のためには、現在のパスワードを入力してください。',
    'profile:loginsession:currentdevice' => 'この端末',
    'profile:loginsession:lastactive(:date)' => '最終アクティブ :date',

    'profile:2fa:title' => '２段階認証',
    'profile:2fa:desc' => '他の端末によるログイン認証を行うことで、セキュリティを強化します。',
    'profile:2fa:explain' => '２段階認証を有効化すると、ログイン時に Google Authenticator アプリでの認証用トークンの発行と入力が求められ、よりセキュアなログイン機能が提供されます。',
    'profile:2fa:explain:app' => 'トークンの認証には Google Authenticator などの認証用アプリケーションが必要となります。事前に認証を行う端末にインストールしてください。',
    'profile:2fa:explain:qr' => '認証アプリケーション用',
    'profile:2fa:explain:recoverycode' => 'リカバリーコードは必ず控えてください。端末の故障や紛失などで認証が行えなくなった場合の復旧で使用します。',
    'profile:2fa:enabled' => '２段階認証がアクティブです。',
    'profile:2fa:disabled' => '２段階認証は無効化されています。',
    'profile:2fa:regenerate_recovery_code' => 'リカバリーコード再生成',
    'profile:2fa:show_recovery_code' => 'リカバリーコードを見る',
    'profile:2fa:enable:confirm_title' => '有効化の確認',
    'profile:2fa:enable:confirm_desc' => '２段階認証を有効化するには、現在のログインパスワードを入力してください。',


    'profile:delete:title' => 'アカウント削除',
    'profile:delete:desc' => 'アプリケーションからアカウントを完全に削除します。',
    'profile:delete:explain' => '一度削除を行うと、関連する全てのデータが削除されます。削除する前に必要なデータのダウンロードを行ってください。',
    'profile:delete:execute' => 'アカウント削除',
    'profile:delete:confirmation' => '本当に削除してよろしいですか？ 一度この動作を行うと取り消しはできません。',
    'profile:delete:confirmation_password' => '削除するために現在のパスワードを入力してください。',


    'team:create:title' => 'チーム作成',
    'team:create:subcaption' => 'チーム作成',
    'team:create:detail' => '新たに自分がオーナーのチームを作成します。',

    'team:settings' => 'チーム設定',

    'team:edit:title' => 'チーム設定変更',
    'team:edit:description' => 'チーム名やメンバーの設定を行います。',

    'team:member:title' => 'チームメンバー追加',
    'team:member:description' => 'メンバーの追加と役割の変更を行います。',
    'team:member:form:explain' => '追加するメンバーのメールアドレスを指定してください。メールアドレスは存在するアカウントの必要があります。',

    'team:delete:title' => 'チーム削除',
    'team:delete:desc' => 'チームを完全に削除します。',
    'team:delete:form:explain' => '一度削除を行うと、関連する全てのデータが削除されます。削除する前に必要なデータのダウンロードを行ってください。',
    'team:delete:confirmation' => '本当に削除してよろしいですか？ 一度この動作を行うと取り消しはできません。',

];
