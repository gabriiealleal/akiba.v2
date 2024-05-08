import { useState } from 'react';
import { toast } from 'react-toastify';
import useUsuarioLogado from '@/interfaces/private/hooks/useUsuarioLogado';
import { useTasks } from '@/services/tasks/queries';
import { useUpdateTasks } from '@/services/tasks/mutations';

const MinhasTarefas = () => {
    const [selectedTask, setSelectedTask] = useState<number>(0);

    const user = useUsuarioLogado();
    const { data: getTasks, isError:tasksError } = useTasks({ user: user?.id });
    const { mutate: updateTaks } = useUpdateTasks({id: selectedTask}, ()=>{
        toast.success('Tarefa concluída com sucesso!')
    });

    function handleUpdateTask(id: number){
        setSelectedTask(id)
        updateTaks({finished: 1});
    }


    if(tasksError){
        return(
            <section className="mt-8">
                <div className="title-default">
                    <h1>Minhas tarefas</h1>
                </div>
                <div className="mt-2 flex justify-center lg:justify-start gap-2 flex-wrap">
                    <div className="w-full xl:w-49.6%  flex items-center justify-between px-4 py-2 bg-gray-700 rounded-md">
                        <span className="text-aurora font-averta truncate w-11/12">Você não possui nenhuma tarefa, caso surja algo apareça aqui.</span>
                        <input type="checkbox" name="tarefa" id="tarefa" disabled/>
                    </div>
                </div>
            </section>
        )
    }

    return(
        <section className="mt-8">
            <div className="title-default">
                <h1>Minhas tarefas</h1>
            </div>
            <div className="mt-2 flex justify-center lg:justify-start gap-2 flex-wrap">
                {getTasks?.tarefas?.slice(0, 6).map((tarefa:any, index:any) => (
                    <div key={index} className="w-full xl:w-49.6%  flex items-center justify-between px-4 py-2 bg-azul-claro rounded-md">
                        <span className="text-aurora font-averta truncate w-11/12">{tarefa?.content}</span>
                        <input type="checkbox" name={`tarefa-${tarefa?.id}`} id={`tarefa-${tarefa?.id}`} onChange={()=>{handleUpdateTask(tarefa?.id)}}/>
                    </div>
                ))}
            </div>
        </section>
    );
};

export default MinhasTarefas;