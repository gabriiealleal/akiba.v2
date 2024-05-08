import { RiArrowRightDoubleLine } from 'react-icons/ri';
import useUsuarioLogado from '@/interfaces/private/hooks/useUsuarioLogado';
import { useNotificationsTeam } from '@/services/notificationsTeam/queries';

const AvisosParaEquipe = () => {
    const user = useUsuarioLogado();
    const { data: getNotificationsTeam, isError: notificationError } = useNotificationsTeam(user?.id);

    if (notificationError) {
        return (
            <section className="mt-8">
                <div className="title-default">
                    <h1>Avisos para a equipe</h1>
                </div>
                <div className="mt-2 flex justify-center lg:justify-start gap-2 flex-wrap">
                    <div className="bg-gray-700 w-full md:w-5/12 xl:w-96 h-40 p-2 rounded-sm">
                        <h1 className="text-aurora text-xl uppercase font-averta font-extrabold italic flex items-center gap-1">
                            Ahn Go-eun <RiArrowRightDoubleLine className="mt-1" /> {user?.nickname}
                        </h1>
                        <p className="mt-1 text-sm text-aurora line-clamp-5 font-averta">
                            Você não possui nenhuma notificação, não se preocupe caso tenha alguma novidade você será informado.
                        </p>
                    </div>
                </div>
            </section>
        )
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
