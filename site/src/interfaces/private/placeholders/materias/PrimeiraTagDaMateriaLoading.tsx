const PrimeiraTagDaMateriaLoading = () => {
    return(
        <>
            <label htmlFor="primeira_tag" className="font-averta font-extrabold text-azul-claro text-lg uppercase text-center italic block">Primeira tag</label>
            <div className="relative">
                <select id="primeira_tag" name="segunda_tag" className="w-full rounded-md p-2 font-averta appearance-none pr-8 outline-none bg-gray-700 rounded-md animate-pulse">
                </select>
            </div>
        </>
    );
}

export default PrimeiraTagDaMateriaLoading;