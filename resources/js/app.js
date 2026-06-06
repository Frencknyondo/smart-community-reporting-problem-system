import './bootstrap';

import * as bootstrap from 'bootstrap';
import L from 'leaflet';
import { Chart, registerables } from 'chart.js';
import Swal from 'sweetalert2';
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

Chart.register(...registerables);
L.Icon.Default.mergeOptions({
    iconRetinaUrl: markerIcon2x,
    iconUrl: markerIcon,
    shadowUrl: markerShadow,
});

window.bootstrap = bootstrap;
window.L = L;
window.Chart = Chart;
window.Swal = Swal;
