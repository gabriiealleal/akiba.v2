import { createBrowserRouter, RouterProvider } from 'react-router-dom';

/**
 * Rotas de toda a interface
 */
const routes = [
    {
        'path': '/',
        'element': <div>Inicio de tudo</div>,
    }
]

/**
 * Esta variavel cria o componente de rotas da interface
 */
const browserRouter = createBrowserRouter(routes);

/**
 * Esta função exporta o componente de rotas da interface
 */
export default function Router() {
    return (
        <RouterProvider router={browserRouter}/>
    )
}