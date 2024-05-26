import React from 'react'
import ReactDOM from 'react-dom/client'
import { ReactQueryDevtools } from '@tanstack/react-query-devtools'
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
const queryClient = new QueryClient();
import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import './tailwind.css';
import './global.css';
import Router from './router/Router';

ReactDOM.createRoot(document.getElementById('root')!).render(
  <React.StrictMode>
    <QueryClientProvider client={queryClient}>
      <ReactQueryDevtools initialIsOpen={false} />
      <ToastContainer position="top-right" autoClose={5000} hideProgressBar={false} newestOnTop={false} closeOnClick rtl={false} pauseOnFocusLoss draggable pauseOnHover theme="colored"/>    
      <Router />
    </QueryClientProvider>
  </React.StrictMode>,
)
