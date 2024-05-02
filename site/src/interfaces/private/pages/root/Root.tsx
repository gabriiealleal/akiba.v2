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

//Importando hooks personalizados
import useUsuarioLogado from '@/interfaces/private/hooks/useUsuarioLogado';

const Root = () => {

    //Utilizando o hook useUsuarioLogado para obter o usuário logado
    const user = useUsuarioLogado();

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
        div.addEventListener('click', () => {
            sidebar.classList.remove('sidebar-visible');
            sidebar.classList.add('sidebar-hidden');
            div.remove();
            setTimeout(() => {
                sidebar.classList.add('hidden');
            }, 300);
        });
    }

    //Função que fecha o sidebar ao clicar em uma das opções
    const closeSidebar = () => {
        //Capturando o elemento sidebar da DOM
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.overlay');
        if (!sidebar) return;
        //Adicionando e removendo classes para mostrar e esconder o sidebar
        sidebar.classList.remove('sidebar-visible');
        sidebar.classList.add('sidebar-hidden');
        setTimeout(() => {
            sidebar.classList.add('hidden');
        }, 300);
        overlay?.remove();
    }

    return (
        <>
            <header>
                <nav className="w-full h-14 lg:h-12 bg-aurora">
                    <div className="flex px-4 lg:w-80rem lg:mx-auto pt-3 lg:pt-2 justify-between items-center">
                        <img className="w-8" src={icone} alt="icone da logo" />
                        <button className="toggle outline-none text-xl text-azul-claro lg:hidden" aria-label="menu" onClick={() => { toggle() }}><HiMenu /></button>
                    </div>
                    <div className="lg:flex lg:justify-center lg:-mt-11">
                        <ul className="sidebar hidden p-4 lg:w-auto h-full fixed lg:sticky top-0 right-0 bg-aurora lg:bg-transparent lg:flex lg:gap-3">
                            <li className="pb-2.5 font-averta font-extrabold italic uppercase">
                                <Link onClick={()=>{closeSidebar()}} className="flex gap-1" to="/painel/dashboard" title="Dashboard" aria-label="Dashboard">
                                    <img src={dashboard} alt="dashboard icone" />Dashboard
                                </Link>
                            </li>
                            {user?.access_levels.includes('administrador') || user?.access_levels.includes('redator') ? (
                                <li className="pb-2.5 font-averta font-extrabold italic uppercase">
                                    <Link onClick={()=>{closeSidebar()}} className="link flex" to="/painel/materias" title="Matérias" aria-label="Matérias">
                                        <img src={materias} alt="matérias icone" />Matérias
                                    </Link>
                                </li>
                            ) : null}
                            {user?.access_levels.includes('administrador') || user?.access_levels.includes('locutor') ? (
                                <li className="pb-2.5 font-averta font-extrabold italic uppercase">
                                    <Link onClick={()=>{closeSidebar()}} className="link flex gap-1" to="/painel/locucao" title="Locução" aria-label="Locução">
                                        <img src={locucao} alt="locução icone" />Locução
                                    </Link>
                                </li>
                            ) : null}
                            {user?.access_levels.includes('administrador') ? (
                                <>
                                    <li className="pb-2.5 font-averta font-extrabold italic uppercase">
                                        <Link onClick={()=>{closeSidebar()}} className="link flex gap-1" to="/painel/radio" title="Rádio" aria-label="Rádio">
                                            <img src={radio} alt="rádio icone" />Rádio
                                        </Link>
                                    </li>
                                    <li className="pb-2.5 font-averta font-extrabold italic uppercase">
                                        <Link onClick={()=>{closeSidebar()}} className="link flex" to="/painel/podcasts" title="Podcasts" aria-label="Podcasts">
                                            <img src={podcast} alt="podcast icone" />Podcasts
                                        </Link>
                                    </li>
                                    <li className="pb-2.5 font-averta font-extrabold italic uppercase">
                                        <Link onClick={()=>{closeSidebar()}} className="link flex gap-1" to="/painel/marketing" title="Marketing" aria-label="Marketing">
                                            <img src={marketing} alt="marketing icone" />Marketing
                                        </Link>
                                    </li>
                                    <li className="pb-2.5 font-averta font-extrabold italic uppercase">
                                        <Link onClick={()=>{closeSidebar()}} className="link flex gap-1" to="/painel/adms" title="Administração" aria-label="Administração">
                                            <img src={adms} alt="adms icone" />ADM's
                                        </Link>
                                    </li>
                                    <li className="pb-2.5 font-averta font-extrabold italic uppercase">
                                        <Link onClick={()=>{closeSidebar()}} className="link flex" to="/painel/logs" title="Logs" aria-label="Logs">
                                            <img src={logs} alt="logs icone" />Log's
                                        </Link>
                                    </li>
                                </>
                            ) : null}
                            <li className="pb-2.5 font-averta font-extrabold italic uppercase">
                                <Link className="link flex" to="/painel/perfil" title="Perfil" aria-label="Perfil">
                                    <img src={perfil} alt="perfil icone" />Perfil
                                </Link>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <main className="mt-10 px-4 lg:w-80rem lg:mx-auto">
                <Outlet />
            </main>

            <footer className="text-center text-aurora leading-6 mb-12 mt-12 px-4">
                © 2016 - {new Date().getFullYear()} Rede Akiba | Versão Ahn Go-eun 1.0<br />
                Designer e planejamento e desenvolvimento <span className="text-laranja">Elyson Santos</span>, <span className="text-laranja">Antônio Medeiros</span> e <span className="text-laranja">João Gabriel</span>
            </footer>
        </>
    );
}

export default Root;