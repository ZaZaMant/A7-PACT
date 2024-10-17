import {Footer} from "./components/Footer.js";
import { Button } from "./components/Button.js";
import { Input } from "./components/form/Input.js";
import { Checkbox } from "./components/form/Checkbox.js";
import { Navbar } from "./components/Navbar.js";
import { Slider } from "./components/form/Slider.js";
import {Select} from "./components/form/Select.js";


// Setup lucide icons
lucide.createIcons(
    {
        attrs:{
            'stroke-width': 1.5,
            'width': '24px',
            'height': '24px',
        }
    }
);



customElements.define("x-checkbox", Checkbox);
customElements.define("x-input", Input);
customElements.define("x-button", Button);
customElements.define("x-navbar", Navbar);
customElements.define("x-slider", Slider);
customElements.define("x-select", Select);
customElements.define('x-footer', Footer);