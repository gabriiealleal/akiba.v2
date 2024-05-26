import { Link } from "react-router-dom";
import { FaNewspaper, FaMicrophoneAlt } from "react-icons/fa";
import { PiBellRingingFill } from "react-icons/pi";
import { ImUpload } from "react-icons/im";
import { BsFillCalendarDateFill, BsMusicNoteList } from "react-icons/bs";
import useUsuarioLogado from '@/interfaces/private/hooks/useUsuarioLogado';

const AcoesRapidas = () => {
    const user = useUsuarioLogado();

    const hasAccess = (level: string) => user?.access_levels?.includes(level);

    const actions = [
        {
            condition: hasAccess('administrador') || hasAccess('redator'),
            to: "/painel/materias",
            title: "nova matéria",
            icon: <FaNewspaper />,
            text: "Nova matéria"
        },
        {
            condition: hasAccess('administrador'),
            to: "/painel/adms",
            title: "criar avisos",
            icon: <PiBellRingingFill />,
            text: "Criar avisos"
        },
        {
            condition: hasAccess('administrador'),
            to: "/painel/marketing",
            title: "deixar arquivos",
            icon: <ImUpload />,
            text: "Deixar arquivos"
        },
        {
            condition: hasAccess('administrador') || hasAccess('locutor'),
            to: "/painel/locucao",
            title: "iniciar programa",
            icon: <FaMicrophoneAlt />,
            text: "Iniciar programa"
        },
        {
            condition: hasAccess('administrador'),
            to: "/painel/midias",
            title: "adicionar eventos",
            icon: <BsFillCalendarDateFill />,
            text: "Adicionar eventos"
        },
        {
            condition: hasAccess('administrador') || hasAccess('locutor'),
            to: "/painel/locucao",
            title: "pedidos musicais",
            icon: <BsMusicNoteList />,
            text: "Pedidos musicais"
        },
    ];

    return (
        <section className="mt-8">
            <div className="title-default">
                <h1>Ações rápidas</h1>
            </div>
            <div className="mt-2 flex justify-center lg:justify-start gap-2 flex-wrap xl:flex-nowrap">
                {actions.map(action => (
                    action.condition && (
                        <Link key={action.title} to={action.to} title={action.title} className="flex items-center gap-1 bg-azul-claro p-1 rounded-md font-averta font-extrabold italic text-aurora uppercase">
                            {action.icon}{action.text}
                        </Link>
                    )
                ))}
            </div>
        </section>
    );
}

export default AcoesRapidas;
