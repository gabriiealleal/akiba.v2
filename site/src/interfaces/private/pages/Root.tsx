import { Link, Outlet } from 'react-router-dom';
import { HiMenu } from "react-icons/hi";
import useUsuarioLogado from '@/interfaces/private/hooks/useUsuarioLogado';
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

const Root = () => {
    const user = useUsuarioLogado();
    const toggle = () => {
        const sidebar = document.querySelector('.sidebar');

        if (!sidebar){
            return
        }

        sidebar.classList.remove('hidden');
        sidebar.classList.remove('sidebar-hidden');
        sidebar.classList.add('sidebar-visible');

        const div = document.createElement('div');
        div.classList.add('overlay');
        div.style.position = 'fixed';
        div.style.inset = '0px';
        div.style.zIndex = '1';
        div.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        document.body.appendChild(div);

        div.addEventListener('click', () => {
            sidebar.classList.remove('sidebar-visible');
            sidebar.classList.add('sidebar-hidden');
            div.remove();
            setTimeout(() => {
                sidebar.classList.add('hidden');
            }, 300);
        });
    }

    const closeSidebar = () => {
        if(window.innerWidth <= 1024){
            const sidebar = document.querySelector('.sidebar');
            if (!sidebar) return;
            sidebar.classList.remove('sidebar-visible');
            sidebar.classList.add('sidebar-hidden');
            setTimeout(() => {
                sidebar.classList.add('hidden');
            }, 300);
        }
    }

    return (
        <>
            <header>
                <nav className="w-full h-14 xl:h-12 bg-aurora">
                    <div className="flex px-4 lg:px-14 w-full xl:w-80rem xl:mx-auto pt-3 xl:pt-2 justify-between items-center">
                        <img className="w-8" src={icone} alt="icone da logo" />
                        <button className="toggle outline-none text-xl text-azul-claro xl:hidden" aria-label="menu" onClick={() => { toggle() }}><HiMenu /></button>
                    </div>
                    <div className="xl:flex xl:justify-center xl:-mt-11">
                        <ul className="sidebar hidden p-4 xl:w-auto h-full fixed xl:sticky top-0 right-0 bg-aurora xl:bg-transparent xl:flex xl:gap-3">
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

            <main className="mt-10 px-4 lg:px-14 w-full xl:w-80rem xl:mx-auto">
                <Outlet />
            </main>

            <footer className="text-center text-aurora leading-6 mb-5 mt-12 px-4">
                © 2016 - {new Date().getFullYear()} Rede Akiba | Versão: Volume 2<br />
                Designer e planejamento e desenvolvimento <span className="text-laranja">Elyson Santos</span>, <span className="text-laranja">Antônio Medeiros</span> e <span className="text-laranja">João Gabriel</span>
            </footer>
        </>
    );
}

export default Root;