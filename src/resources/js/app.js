import './bootstrap';
import { mainJs } from './main';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


window.APP_FUNC = {
    // "requireConfirm":(thisV) =>{ requireConfirm(thisV)}
    "inputFunc": inputFunc,
}

