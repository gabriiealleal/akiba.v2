import React from 'react'
import ReactDOM from 'react-dom/client'

/**
 * Importando o componente Router que é responsável por gerenciar as rotas da aplicação.
 */
import Router from './router/Router'

/**
 * Importando o css global da aplicação.
 */
import './global.css';


ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <Router />
  </React.StrictMode>,
)
