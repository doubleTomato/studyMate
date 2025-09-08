import './bootstrap';
import { inputFunc } from './main';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


window.APP_FUNC = {
    // "requireConfirm":(thisV) =>{ requireConfirm(thisV)}
    "inputFunc": inputFunc,
}

