import { Link, Outlet } from 'react-router-dom';

//Importando assets
import icone from '/images/icone.webp';
import dashboard from '/svg/DASHBOARD.svg';
import materias from '/svg/MATERIAS.svg';
import locucao from '/svg/LOCUÇÃO.svg';
import radio from '/svg/RADIO.svg';
import podcast from '/svg/PODCAST.svg';
import marketing from '/svg/MARKETING.svg';
import adms from '/svg/ADMS.svg';
import logs from '/svg/LOGS.svg';
import perfil from '/svg/PERFIL.svg';

//Importando icones
import { HiMenu } from "react-icons/hi";

const Root = () => {

    //Função para mostrar e esconder o sidebar
    const toggle = () => {
        //Capturando o elemento sidebar da DOM
        const sidebar = document.querySelector('.sidebar');

        if (!sidebar) return;
        //Adicionando e removendo classes para mostrar e esconder o sidebar
        sidebar.classList.remove('hidden');
        sidebar.classList.remove('sidebar-hidden');
        sidebar.classList.add('sidebar-visible');

        //Criando div fantasma para fechar o sidebar
        const div = document.createElement('div');
        div.classList.add('overlay');
        div.style.position = 'fixed';
        div.style.inset = '0px';
        div.style.zIndex = '1';
        div.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        document.body.appendChild(div);

        //Adicionando evento de click para fechar o sidebar
        div.addEventListener('click', () =>{
            sidebar.classList.remove('sidebar-visible');
            sidebar.classList.add('sidebar-hidden');
            div.remove();
            setTimeout(() => {
                sidebar.classList.add('hidden');
            }, 300);
        });
    }

    return (
        <div className="h-screen bg-azul-escuro">
            <header>
                <nav className="w-full h-14 lg:h-12 bg-aurora">
                    <div className="flex px-4 pt-3 lg:pt-2 justify-between items-center">
                        <img className="w-8" src={icone} alt="icone da logo" />
                        <button className="toggle outline-none text-xl text-azul-claro lg:hidden" aria-label="menu" onClick={()=>{toggle()}}><HiMenu /></button>
                    </div>
                    <div className="lg:flex lg:justify-center lg:-mt-11">
                        <ul className="sidebar hidden p-4 lg:w-auto h-full fixed lg:sticky top-0 right-0 bg-aurora lg:bg-transparent lg:flex lg:gap-3">
                            <li className="pb-2.5 font-bold uppercase">
                                <Link className="flex gap-1" to="/painel/dashboard" title="Dashboard" aria-label="Dashboard">
                                    <img src={dashboard} alt="dashboard icone" />Dashboard
                                </Link>
                            </li>
                            <li className="pb-2.5 font-bold uppercase">
                                <Link className="flex" to="/painel/materias" title="Matérias" aria-label="Matérias">
                                    <img src={materias} alt="matérias icone" />Matérias
                                </Link>
                            </li>
                            <li className="pb-2.5 font-bold uppercase">
                                <Link className="flex gap-1" to="/painel/locucao" title="Locução" aria-label="Locução">
                                    <img src={locucao} alt="locução icone" />Locução
                                </Link>
                            </li>
                            <li className="pb-2.5 font-bold uppercase">
                                <Link className="flex gap-1" to="/painel/radio" title="Rádio" aria-label="Rádio">
                                    <img src={radio} alt="rádio icone" />Rádio
                                </Link>
                            </li>
                            <li className="pb-2.5 font-bold uppercase">
                                <Link className="flex" to="/painel/podcasts" title="Podcasts" aria-label="Podcasts">
                                    <img src={podcast} alt="podcast icone" />Podcasts
                                </Link>
                            </li>
                            <li className="pb-2.5 font-bold uppercase">
                                <Link className="flex gap-1" to="/painel/marketing" title="Marketing" aria-label="Marketing">
                                    <img src={marketing} alt="marketing icone" />Marketing
                                </Link>
                            </li>
                            <li className="pb-2.5 font-bold uppercase">
                                <Link className="flex gap-1" to="/painel/adms" title="Administração" aria-label="Administração">
                                    <img src={adms} alt="adms icone" />ADM's
                                </Link>
                            </li>
                            <li className="pb-2.5 font-bold uppercase">
                                <Link className="flex" to="/painel/logs" title="Logs" aria-label="Logs">
                                    <img src={logs} alt="logs icone" />Log's
                                </Link>
                            </li>
                            <li className="pb-2.5 font-bold uppercase">
                                <Link className="flex" to="/painel/perfil" title="Perfil" aria-label="Perfil">
                                    <img src={perfil} alt="perfil icone" />Perfil
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