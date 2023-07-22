import React from 'react';
import './bootstrap';
import App from './App';
import axios from 'axios';
import Alpine from 'alpinejs';
import { createRoot } from 'react-dom/client';


window.Alpine = Alpine;

Alpine.start();
axios.defaults.withCredentials = true;
const container = document.getElementById('app');
const root = createRoot(container!); 

root.render(
  // <React.StrictMode>
        <App />
  /* </React.StrictMode>, */
);