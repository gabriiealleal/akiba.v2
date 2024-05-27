import { RiArrowRightDoubleLine } from 'react-icons/ri';
import useUsuarioLogado from '@/interfaces/private/hooks/useUsuarioLogado';
import { useNotificationsTeam } from '@/services/notifications_team/queries';
import AvisosParaEquipeError from '@/interfaces/private/placeholders/dashboard/avisos_para_equipe/AvisosParaEquipeError';
import AvisosParaEquipeLoading from '@/interfaces/private/placeholders/dashboard/avisos_para_equipe/AvisosParaEquipeLoading';

const AvisosParaEquipe = () => {
    const user = useUsuarioLogado();
    const { data: getNotificationsTeam, isLoading, isError } = useNotificationsTeam(user?.id);

    if(isLoading){
        return <AvisosParaEquipeLoading />
    }else if(isError){
        return <AvisosParaEquipeError nickname={user?.nickname} />
    }

    return (
        <section className="mt-8">
            <div className="title-default">
                <h1>Avisos para a equipe</h1>
            </div>
            <div className="mt-2 flex justify-center lg:justify-start gap-2 flex-wrap xl:flex-nowrap">
                {getNotificationsTeam?.notificações?.slice(0, 6).map((notificacao: any) => (
                    <div key={notificacao.id} className="bg-azul-claro w-full md:w-5/12 xl:w-96 h-40 p-2 rounded-sm">
                        <h1 className="text-aurora text-lg uppercase font-averta font-extrabold italic flex items-center gap-1">
                            {notificacao.creator.nickname} <RiArrowRightDoubleLine className="mt-1" /> {notificacao.addressee === null ? "Toda a equipe" : notificacao.addressee.nickname}
                        </h1>
                        <p className="mt-1 text-sm text-aurora line-clamp-5 font-averta">
                            {notificacao.content}
                        </p>
                    </div>
                ))}
            </div>
        </section>
    );
};

export default AvisosParaEquipe;
