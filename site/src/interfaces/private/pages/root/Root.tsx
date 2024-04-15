import { Link, Outlet } from 'react-router-dom';

//Importando assets
import icone from '/images/icone.webp';

//Importando icones
import { HiMenu } from "react-icons/hi";

const Root = () => {
    return (
        <div className="h-screen bg-azul-escuro">
            <header>
                <nav className="w-full h-14 md:h-12 bg-aurora">
                    <div className="flex px-4 pt-3 md:pt-2 justify-between items-center">
                        <img className="w-8" src={icone} alt="icone da logo" />
                        <button className="outline-none text-xl text-azul-claro md:hidden" aria-label="menu"><HiMenu /></button>
                    </div>
                    <div className="md:flex md:justify-center md:-mt-11">
                        <ul className="p-4 w-48 md:w-auto h-full fixed md:sticky top-0 right-0 bg-aurora md:bg-transparent md:flex md:gap-3">
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
                    </div>
                </nav>
            </header>
            <Outlet />
        </div>
    );
}

export default Root;