import { BrowserRouter, Route, Routes } from "react-router-dom";

//Importando os componentes privados
import Root from "@/interfaces/private/pages/root/Root.tsx";
import Auth from "@/interfaces/private/pages/auth/Auth.tsx";

const Router = () => {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/painel" element={<Auth />} />
                <Route path="/painel/*" element={<Root />} >
                    <Route path="dashboard"/>
                </Route>
            </Routes>
        </BrowserRouter>
    );
}

export default Router;
