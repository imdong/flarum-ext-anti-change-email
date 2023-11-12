import app from 'flarum/admin/app';
import {extPrefix, trans, key} from "../common";

app.initializers.add(extPrefix, () => {
  app.extensionData
    .for(extPrefix)
    // 添加权限 修改邮箱
    .registerPermission(
      {
        icon: 'fas fa-envelope',
        label: trans( 'admin.permissions.change-email'),
        permission: key(`changeEmail`),
      },
      'reply'
    )

});
