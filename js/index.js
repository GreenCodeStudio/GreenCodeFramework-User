import {pageManager} from "../../Core/js/pageManager";

pageManager.registerController('User', () => import('./Controllers/User'));
pageManager.registerController('Token', () => import('./Controllers/Token'));
