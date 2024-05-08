import { BrowserRouter, Route, Routes } from "react-router-dom";

//Importando middleware para rotas privadas
import PrivateRouter from "@/router/PrivateRouter.tsx";

//Importando os componentes privados
import Root from "@/interfaces/private/pages/Root";
import Auth from "@/interfaces/private/pages/Auth";
import Dashboard from "@/interfaces/private/pages/Dashboard";

const Router = () => {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/painel" element={<Auth />} />
                <Route path="/painel/*" element={<Root/>}>
                    <Route path="dashboard" element={<PrivateRouter View={Dashboard} />} />
                </Route>
            </Routes>
        </BrowserRouter>
    );
}

export default Router;
