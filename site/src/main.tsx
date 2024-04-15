import React from 'react'
import ReactDOM from 'react-dom/client'

//Import the React Query
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";

//Create a new query client
const queryClient = new QueryClient();

//Import the toastify styles
import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

//Import the tailwind stylesheet
import './tailwind.css';

//Import the routes
import Router from './router/Router';

ReactDOM.createRoot(document.getElementById('root')!).render(
  <React.StrictMode>
    <QueryClientProvider client={queryClient}>
      <ToastContainer position="top-right" autoClose={5000} hideProgressBar={false} newestOnTop={false} closeOnClick rtl={false} pauseOnFocusLoss draggable pauseOnHover theme="colored"/>    
      <Router />
    </QueryClientProvider>
  </React.StrictMode>,
)
