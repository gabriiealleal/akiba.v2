import { createBrowserRouter, RouterProvider } from 'react-router-dom';

/**
 * Rotas de toda a interface
 */
const routes = [
    {
        'path': '/',
        'element':    <h1 className="text-3xl font-bold underline">
        Hello world!
      </h1>,
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