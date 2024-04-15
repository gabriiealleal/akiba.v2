import { Link, Outlet } from 'react-router-dom';

//Importando assets
import icone from '/images/icone.webp';

//Importando icones
import { HiMenu } from "react-icons/hi";

const Root = () => {
    return (
        <div className="h-screen bg-azul-escuro">
            <header>
                <nav className="w-full h-14 lg:h-12 bg-aurora">
                    <div className="flex px-4 pt-3 lg:pt-2 justify-between items-center">
                        <img className="w-8" src={icone} alt="icone da logo" />
                        <button className="outline-none text-xl text-azul-claro lg:hidden" aria-label="menu"><HiMenu /></button>
                    </div>
                    <ul className="p-4 w-48 h-full fixed top-0 right-0 bg-aurora">
                        <li className="pb-2.5 font-bold uppercase">
                            <Link to="/painel/dashboard" title="Dashboard" aria-label="Dashboard">
                                Dashboard
                            </Link>
                        </li>
                        <li className="pb-2.5 font-bold uppercase">
                            <Link to="/painel/materias" title="Matérias" aria-label="Matérias">
                                Matérias
                            </Link>
                        </li>
                        <li className="pb-2.5 font-bold uppercase">
                            <Link to="/painel/locucao" title="Locução" aria-label="Locução">
                                Locução
                            </Link>
                        </li>
                        <li className="pb-2.5 font-bold uppercase">
                            <Link to="/painel/radio" title="Rádio" aria-label="Rádio">
                                Rádio
                            </Link>
                        </li>
                        <li className="pb-2.5 font-bold uppercase">
                            <Link to="/painel/podcasts" title="Podcasts" aria-label="Podcasts">
                                Podcasts
                            </Link>
                        </li>
                        <li className="pb-2.5 font-bold uppercase">
                            <Link to="/painel/marketing" title="Marketing" aria-label="Marketing">
                                Marketing
                            </Link>
                        </li>
                        <li className="pb-2.5 font-bold uppercase">
                            <Link to="/painel/adms" title="Administração" aria-label="Administração">
                                ADM's
                            </Link>
                        </li>
                        <li className="pb-2.5 font-bold uppercase">
                            <Link to="/painel/logs" title="Logs" aria-label="Logs">
                                Log's
                            </Link>
                        </li>
                        <li className="pb-2.5 font-bold uppercase">
                            <Link to="/painel/perfil" title="Perfil" aria-label="Perfil">
                                Perfil
                            </Link>
                        </li>
                    </ul>
                </nav>
            </header>
            <Outlet />
        </div>
    );
}

export default Root;