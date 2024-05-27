const MinhasTarefasError = () => {
    return (
        <section className="mt-8">
            <div className="title-default">
                <h1>Minhas tarefas</h1>
            </div>
            <div className="mt-2 flex justify-center lg:justify-start gap-2 flex-wrap">
                <div className="w-full xl:w-49.6%  flex items-center justify-between px-4 py-2 bg-gray-700 rounded-md">
                    <span className="text-aurora font-averta truncate w-11/12">Você pode assistir seus animes em paz! Não há tarefas!</span>
                    <input type="checkbox" name="tarefa" id="tarefa" disabled />
                </div>
            </div>
        </section>
    )
}

export default MinhasTarefasError;