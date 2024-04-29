import { RiArrowRightDoubleLine } from 'react-icons/ri';
import { useTasks } from '@/services/tasks/queries';

const AvisosParaEquipe = () => {
    // Utilizando a query useTasks para obter as tarefas
    const { data: getTasks, isError, error } = useTasks();

    // Função para renderizar o erro de maneira amigável
    const renderError = (error: any) => {
        return (
            <div className="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p className="font-bold">Erro ao Carregar</p>
                <p>{error?.response?.data?.message || "Houve um erro ao tentar buscar as tarefas. Tente novamente mais tarde."}</p>
            </div>
        );
    };

    return (
        <section className="mt-8">
            <div className="title-default">
                <h1>Avisos para a equipe</h1>
            </div>
            {isError ? (
                renderError(error)
            ) : (
                <div className="mt-4 flex justify-center gap-2 flex-wrap lg:flex-nowrap">
                    {getTasks?.tarefas?.map((task: any) => (
                        <div key={task.id} className="bg-azul-claro w-full md:w-5/12 lg:w-1/3 h-40 p-3 rounded-lg">
                            <h1 className="text-aurora text-xl uppercase font-bold flex items-center gap-1">
                                {task.creator} <RiArrowRightDoubleLine /> Takashi
                            </h1>
                            <p className="mt-1 text-aurora text-ellipsis overflow-hidden">
                                Olá, Takashi. O que acha de fazermos uma reunião para discutirmos o novo projeto de locução?
                            </p>
                        </div>
                    ))}
                </div>
            )}
        </section>
    );
};

export default AvisosParaEquipe;
