import app from 'flarum/forum/app';
import {extPrefix} from "../common";
import {extend} from 'flarum/common/extend';
import SettingsPage from "flarum/forum/components/SettingsPage";

export { default as extend } from './extend';

app.initializers.add(extPrefix, () => {

  extend(SettingsPage.prototype, 'accountItems', function (items) {
    if (!this.user.canChangeEmail()) {
      items.remove('changeEmail')
    }
  })

});
