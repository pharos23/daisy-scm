// JS File to call the scripts needed for this page (in this case: users page)
import {setupSearchUser, updateWaitWheel} from "../event-handler/updateWaitWheel.js";

document.addEventListener('DOMContentLoaded', () => {
    updateWaitWheel();
});
